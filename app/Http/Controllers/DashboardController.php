<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function getStats()
    {
        // 1. Nombre total d'applications
        $totalApps = DB::table('catalogues')->count();

        // 2. Nombre total d'environnements
        $totalEnvironments = DB::table('catalogues')
            ->selectRaw('
                COUNT(env_dev) as dev_count,
                COUNT(env_prod) as prod_count,
                COUNT(env_test) as test_count
            ')
            ->first();

        $totalEnvironmentsCount = $totalEnvironments->dev_count + $totalEnvironments->prod_count + $totalEnvironments->test_count;

        // 3. Pourcentage d'environnements dev/prod/test
        $envPercentages = [
            'dev' => $totalEnvironmentsCount > 0 ? ($totalEnvironments->dev_count / $totalEnvironmentsCount) * 100 : 0,
            'prod' => $totalEnvironmentsCount > 0 ? ($totalEnvironments->prod_count / $totalEnvironmentsCount) * 100 : 0,
            'test' => $totalEnvironmentsCount > 0 ? ($totalEnvironments->test_count / $totalEnvironmentsCount) * 100 : 0,
        ];

        // 4. Pourcentage d'environnements actif/inactif par type
        $statusPercentages = DB::table('catalogues')
            ->selectRaw('
                SUM(CASE WHEN statut_dev = "actif" THEN 1 ELSE 0 END) as dev_actif,
                SUM(CASE WHEN statut_dev = "inactif" THEN 1 ELSE 0 END) as dev_inactif,
                SUM(CASE WHEN statut_prod = "actif" THEN 1 ELSE 0 END) as prod_actif,
                SUM(CASE WHEN statut_prod = "inactif" THEN 1 ELSE 0 END) as prod_inactif,
                SUM(CASE WHEN statut_test = "actif" THEN 1 ELSE 0 END) as test_actif,
                SUM(CASE WHEN statut_test = "inactif" THEN 1 ELSE 0 END) as test_inactif
            ')
            ->first();

        $statusPercentagesResult = [
            'dev' => [
                'actif' => $totalEnvironments->dev_count > 0 ? ($statusPercentages->dev_actif / $totalEnvironments->dev_count) * 100 : 0,
                'inactif' => $totalEnvironments->dev_count > 0 ? ($statusPercentages->dev_inactif / $totalEnvironments->dev_count) * 100 : 0,
            ],
            'prod' => [
                'actif' => $totalEnvironments->prod_count > 0 ? ($statusPercentages->prod_actif / $totalEnvironments->prod_count) * 100 : 0,
                'inactif' => $totalEnvironments->prod_count > 0 ? ($statusPercentages->prod_inactif / $totalEnvironments->prod_count) * 100 : 0,
            ],
            'test' => [
                'actif' => $totalEnvironments->test_count > 0 ? ($statusPercentages->test_actif / $totalEnvironments->test_count) * 100 : 0,
                'inactif' => $totalEnvironments->test_count > 0 ? ($statusPercentages->test_inactif / $totalEnvironments->test_count) * 100 : 0,
            ],
        ];

        // 5. Services critiques les plus fréquents
        $criticalServices = DB::table('catalogues')
            ->selectRaw('
                JSON_UNQUOTE(JSON_EXTRACT(critical_dev, "$")) as dev_services,
                JSON_UNQUOTE(JSON_EXTRACT(critical_prod, "$")) as prod_services,
                JSON_UNQUOTE(JSON_EXTRACT(critical_test, "$")) as test_services
            ')
            ->get();

        $servicesCount = [];
        foreach ($criticalServices as $row) {
            foreach (['dev_services', 'prod_services', 'test_services'] as $field) {
                if ($row->$field) {
                    $services = json_decode($row->$field, true);
                    if (is_array($services)) {
                        foreach ($services as $service) {
                            $servicesCount[$service] = ($servicesCount[$service] ?? 0) + 1;
                        }
                    }
                }
            }
        }

        // Trier les services par fréquence
        arsort($servicesCount);
        $topCriticalServices = array_slice($servicesCount, 0, 3, true); // Top 5 services

        $sessionId = Session::getId();

        // Transmission des données à la vue
        return view('pages.Dashboard.dashboard', [
            'total_applications' => $totalApps,
            'total_environments' => $totalEnvironmentsCount,
            'environment_percentages' => [
                'dev' => round($envPercentages['dev'], 2),
                'prod' => round($envPercentages['prod'], 2),
                'test' => round($envPercentages['test'], 2),
            ],
            'status_percentages' => [
                'dev' => [
                    'actif' => round($statusPercentagesResult['dev']['actif'], 2),
                    'inactif' => round($statusPercentagesResult['dev']['inactif'], 2),
                ],
                'prod' => [
                    'actif' => round($statusPercentagesResult['prod']['actif'], 2),
                    'inactif' => round($statusPercentagesResult['prod']['inactif'], 2),
                ],
                'test' => [
                    'actif' => round($statusPercentagesResult['test']['actif'], 2),
                    'inactif' => round($statusPercentagesResult['test']['inactif'], 2),
                ],
            ],
            'top_critical_services' => $topCriticalServices,

        ]);
    }
}
