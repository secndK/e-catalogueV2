<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchHistory;
use App\Exports\CatalogueExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NouvelleDemandeServeurNotification;
use Maatwebsite\Excel\Facades\Excel;


class CatalogueController extends Controller
{
    /**Cette fonction servira à recupérer l'ensemble des données pour les afficher dans la vue */

    public function getCatalogue()
    {
        $catalogue = DB::table('catalogues')
            ->orderBy('app_name', 'ASC')
            ->paginate(3);

        return view('pages.catalogue.application', [

            'catalogue' => $catalogue,
            'search_query' => '',
            'show_all' => true,
        ]);
    }

    /**Cette fonction servira à recupérer l'ensemble des données pour les afficher dans la vue
     * après avoir entre le nom au l'ip correspondant de l'application
     */

    public function postCatalogue(Request $request)
    {
        $searchQuery = $request->post('rechercher', '');
        $perPage = 3; // pagination forcé pour afficher que 3 app max

        if (!empty($searchQuery)) {
            $lowerSearch = strtolower($searchQuery);
            $catalogue = DB::table('catalogues')
                ->where(function ($query) use ($lowerSearch) {
                    $query->whereRaw('LOWER(app_name) LIKE ?', ['%' . $lowerSearch . '%'])
                        ->orWhereRaw('LOWER(url_app) LIKE ?', ['%' . $lowerSearch . '%'])
                        ->orWhereRaw('LOWER(url_doc) LIKE ?', ['%' . $lowerSearch . '%'])
                        ->orWhereRaw('LOWER(url_git) LIKE ?', ['%' . $lowerSearch . '%'])
                        ->orWhereRaw('LOWER(adr_serv_dev) = ?', [$lowerSearch])
                        ->orWhereRaw('LOWER(adr_serv_test) = ?', [$lowerSearch])
                        ->orWhereRaw('LOWER(adr_serv_prod) LIKE ?', ['%' . $lowerSearch . '%']);
                })
                ->orderBy('app_name', 'ASC')
                ->paginate($perPage)
                ->appends($request->query());
        } else {

            $catalogue = DB::table('catalogues')
                ->orderBy('app_name', 'ASC')
                ->paginate($perPage);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'query' => $searchQuery
            ]);
        }


        return view('pages.catalogue.application', [
            'catalogue' => $catalogue,
            'search_query' => $searchQuery,

        ]);
    }

    // recuperer les données des recherche recentes par session

    /** Cette fonction servira à ajouter une nouvelle app à la bd */
    public function createCatalogue(Request $request)
    {
        $validatedData = $request->validate([
            'app_name' => 'required|string|max:255',
            'desc_app' => 'nullable|string|max:255',
            'url_app' => 'nullable|url|max:255',
            'url_doc' => 'nullable|url|max:255',
            'url_git' => 'nullable|url|max:255',

            // Environnement DEV
            'env_dev' => 'nullable|string|max:255',
            'adr_serv_dev' => 'nullable|string|max:255',
            'nom_dns' => 'nullable|string|max:255',
            'sys_exp_dev' => 'nullable|string|max:255',
            'adr_serv_bd_dev' => 'nullable|string|max:255',
            'sys_exp_bd_dev' => 'nullable|string|max:255',
            'lang_deve_dev' => 'nullable|string|max:255',
            'critical_dev' => 'nullable|array',
            'critical_dev.*' => 'string|max:255',
            'statut_dev' => 'nullable|string|max:255',
            'url_dev' => 'nullable|url|max:255',
            'vers_sys_dev' => 'nullable|string|max:255',
            'dist_sys_dev' => 'nullable|string|max:255',
            'nom_bd_dev' => 'nullable|string|max:255',
            'port_bd_dev' => 'nullable|string|max:255',
            'user_bd_dev' => 'nullable|string|max:255',
            'vers_lang_dev' => 'nullable|string|max:255',
            'fram_dev' => 'nullable|string|max:255',
            'vers_fram_dev' => 'nullable|string|max:255',

            // Environnement PROD
            'env_prod' => 'nullable|string|max:255',
            'adr_serv_prod' => 'nullable|string|max:255',
            'sys_exp_prod' => 'nullable|string|max:255',
            'adr_serv_bd_prod' => 'nullable|string|max:255',
            'sys_exp_bd_prod' => 'nullable|string|max:255',
            'lang_deve_prod' => 'nullable|string|max:255',
            'critical_prod' => 'nullable|array',
            'critical_prod.*' => 'string|max:255',
            'statut_prod' => 'nullable|string|max:255',
            'url_prod' => 'nullable|url|max:255',
            'vers_sys_prod' => 'nullable|string|max:255',
            'dist_sys_prod' => 'nullable|string|max:255',
            'nom_bd_prod' => 'nullable|string|max:255',
            'port_bd_prod' => 'nullable|string|max:255',
            'user_bd_prod' => 'nullable|string|max:255',
            'vers_lang_prod' => 'nullable|string|max:255',
            'fram_prod' => 'nullable|string|max:255',
            'vers_fram_prod' => 'nullable|string|max:255',

            // Environnement TEST
            'env_test' => 'nullable|string|max:255',
            'adr_serv_test' => 'nullable|string|max:255',
            'sys_exp_test' => 'nullable|string|max:255',
            'adr_serv_bd_test' => 'nullable|string|max:255',
            'sys_exp_bd_test' => 'nullable|string|max:255',
            'lang_deve_test' => 'nullable|string|max:255',
            'critical_test' => 'nullable|array',
            'critical_test.*' => 'string|max:255',
            'statut_test' => 'nullable|string|max:255',
            'url_test' => 'nullable|url|max:255',
            'vers_sys_test' => 'nullable|string|max:255',
            'dist_sys_test' => 'nullable|string|max:255',
            'nom_bd_test' => 'nullable|string|max:255',
            'port_bd_test' => 'nullable|string|max:255',
            'user_bd_test' => 'nullable|string|max:255',
            'vers_lang_test' => 'nullable|string|max:255',
            'fram_test' => 'nullable|string|max:255',
            'vers_fram_test' => 'nullable|string|max:255',
        ]);

        $data = [
            'app_name' => $validatedData['app_name'],
            'desc_app' => $validatedData['desc_app'],
            'url_app' => $validatedData['url_app'],
            'url_doc' => $validatedData['url_doc'],
            'url_git' => $validatedData['url_git'],

            // DEV
            'env_dev' => $validatedData['env_dev'],
            'adr_serv_dev' => $validatedData['adr_serv_dev'],
            'nom_dns' => $validatedData['nom_dns'],
            'sys_exp_dev' => $validatedData['sys_exp_dev'],
            'adr_serv_bd_dev' => $validatedData['adr_serv_bd_dev'],
            'sys_exp_bd_dev' => $validatedData['sys_exp_bd_dev'],
            'lang_deve_dev' => $validatedData['lang_deve_dev'],
            'critical_dev' => $this->cleanCriticalData($validatedData['critical_dev'] ?? []),
            'statut_dev' => $validatedData['statut_dev'],
            'url_dev' => $validatedData['url_dev'],
            'vers_sys_dev' => $validatedData['vers_sys_dev'],
            'dist_sys_dev' => $validatedData['dist_sys_dev'],
            'nom_bd_dev' => $validatedData['nom_bd_dev'],
            'port_bd_dev' => $validatedData['port_bd_dev'],
            'user_bd_dev' => $validatedData['user_bd_dev'],
            'vers_lang_dev' => $validatedData['vers_lang_dev'],
            'fram_dev' => $validatedData['fram_dev'],
            'vers_fram_dev' => $validatedData['vers_fram_dev'],

            // PROD
            'env_prod' => $validatedData['env_prod'],
            'adr_serv_prod' => $validatedData['adr_serv_prod'],
            'sys_exp_prod' => $validatedData['sys_exp_prod'],
            'adr_serv_bd_prod' => $validatedData['adr_serv_bd_prod'],
            'sys_exp_bd_prod' => $validatedData['sys_exp_bd_prod'],
            'lang_deve_prod' => $validatedData['lang_deve_prod'],
            'critical_prod' => $this->cleanCriticalData($validatedData['critical_prod'] ?? []),
            'statut_prod' => $validatedData['statut_prod'],
            'url_prod' => $validatedData['url_prod'],
            'vers_sys_prod' => $validatedData['vers_sys_prod'],
            'dist_sys_prod' => $validatedData['dist_sys_prod'],
            'nom_bd_prod' => $validatedData['nom_bd_prod'],
            'port_bd_prod' => $validatedData['port_bd_prod'],
            'user_bd_prod' => $validatedData['user_bd_prod'],
            'vers_lang_prod' => $validatedData['vers_lang_prod'],
            'fram_prod' => $validatedData['fram_prod'],
            'vers_fram_prod' => $validatedData['vers_fram_prod'],

            // TEST
            'env_test' => $validatedData['env_test'],
            'adr_serv_test' => $validatedData['adr_serv_test'],
            'sys_exp_test' => $validatedData['sys_exp_test'],
            'adr_serv_bd_test' => $validatedData['adr_serv_bd_test'],
            'sys_exp_bd_test' => $validatedData['sys_exp_bd_test'],
            'lang_deve_test' => $validatedData['lang_deve_test'],
            'critical_test' => $this->cleanCriticalData($validatedData['critical_test'] ?? []),
            'statut_test' => $validatedData['statut_test'],
            'url_test' => $validatedData['url_test'],
            'vers_sys_test' => $validatedData['vers_sys_test'],
            'dist_sys_test' => $validatedData['dist_sys_test'],
            'nom_bd_test' => $validatedData['nom_bd_test'],
            'port_bd_test' => $validatedData['port_bd_test'],
            'user_bd_test' => $validatedData['user_bd_test'],
            'vers_lang_test' => $validatedData['vers_lang_test'],
            'fram_test' => $validatedData['fram_test'],
            'vers_fram_test' => $validatedData['vers_fram_test'],
        ];

        try {
            DB::table('catalogues')->insert($data);

            return $request->ajax()
                ? response()->json(['success' => true, 'message' => 'Application créée avec succès.'])
                : redirect()->back()->with('success', 'Application créée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur création catalogue: ' . $e->getMessage());

            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Erreur lors de la création.'], 500)
                : redirect()->back()->with('error', 'Erreur lors de la création.');
        }
    }



    public function editCatalogue($id)
    {
        try {
            $app = DB::connection('mysql')->table('catalogues')->where('id', $id)->first();

            if (!$app) {
                return response()->json([
                    'success' => false,
                    'message' => 'Application non trouvée.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $app
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur récupération application: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de l\'application.'
            ], 500);
        }
    }

    public function updateCatalogue(Request $request, $id)
    {
        $validatedData = $request->validate([
            'app_name' => 'required|string|max:255',
            'desc_app' => 'nullable|string|max:255',
            'url_app' => 'nullable|url|max:255',
            'url_doc' => 'nullable|url|max:255',
            'url_git' => 'nullable|url|max:255',

            // Environnement DEV
            'env_dev' => 'nullable|string|max:255',
            'adr_serv_dev' => 'nullable|string|max:255',
            'nom_dns' => 'nullable|string|max:255',
            'sys_exp_dev' => 'nullable|string|max:255',
            'adr_serv_bd_dev' => 'nullable|string|max:255',
            'sys_exp_bd_dev' => 'nullable|string|max:255',
            'lang_deve_dev' => 'nullable|string|max:255',
            'critical_dev' => 'nullable|array',
            'critical_dev.*' => 'string|max:255',
            'statut_dev' => 'nullable|string|max:255',
            'url_dev' => 'nullable|url|max:255',
            'vers_sys_dev' => 'nullable|string|max:255',
            'dist_sys_dev' => 'nullable|string|max:255',
            'nom_bd_dev' => 'nullable|string|max:255',
            'port_bd_dev' => 'nullable|string|max:255',
            'user_bd_dev' => 'nullable|string|max:255',
            'vers_lang_dev' => 'nullable|string|max:255',
            'fram_dev' => 'nullable|string|max:255',
            'vers_fram_dev' => 'nullable|string|max:255',

            // Environnement PROD
            'env_prod' => 'nullable|string|max:255',
            'adr_serv_prod' => 'nullable|string|max:255',
            'sys_exp_prod' => 'nullable|string|max:255',
            'adr_serv_bd_prod' => 'nullable|string|max:255',
            'sys_exp_bd_prod' => 'nullable|string|max:255',
            'lang_deve_prod' => 'nullable|string|max:255',
            'critical_prod' => 'nullable|array',
            'critical_prod.*' => 'string|max:255',
            'statut_prod' => 'nullable|string|max:255',
            'url_prod' => 'nullable|url|max:255',
            'vers_sys_prod' => 'nullable|string|max:255',
            'dist_sys_prod' => 'nullable|string|max:255',
            'nom_bd_prod' => 'nullable|string|max:255',
            'port_bd_prod' => 'nullable|string|max:255',
            'user_bd_prod' => 'nullable|string|max:255',
            'vers_lang_prod' => 'nullable|string|max:255',
            'fram_prod' => 'nullable|string|max:255',
            'vers_fram_prod' => 'nullable|string|max:255',

            // Environnement TEST
            'env_test' => 'nullable|string|max:255',
            'adr_serv_test' => 'nullable|string|max:255',
            'sys_exp_test' => 'nullable|string|max:255',
            'adr_serv_bd_test' => 'nullable|string|max:255',
            'sys_exp_bd_test' => 'nullable|string|max:255',
            'lang_deve_test' => 'nullable|string|max:255',
            'critical_test' => 'nullable|array',
            'critical_test.*' => 'string|max:255',
            'statut_test' => 'nullable|string|max:255',
            'url_test' => 'nullable|url|max:255',
            'vers_sys_test' => 'nullable|string|max:255',
            'dist_sys_test' => 'nullable|string|max:255',
            'nom_bd_test' => 'nullable|string|max:255',
            'port_bd_test' => 'nullable|string|max:255',
            'user_bd_test' => 'nullable|string|max:255',
            'vers_lang_test' => 'nullable|string|max:255',
            'fram_test' => 'nullable|string|max:255',
            'vers_fram_test' => 'nullable|string|max:255',
        ]);

        // Nettoyage des doublons avant encodage
        $data = [
            'app_name' => $validatedData['app_name'],
            'desc_app' => $validatedData['desc_app'],
            'url_app' => $validatedData['url_app'],
            'url_doc' => $validatedData['url_doc'],
            'url_git' => $validatedData['url_git'],

            // DEV
            'env_dev' => $validatedData['env_dev'],
            'adr_serv_dev' => $validatedData['adr_serv_dev'],
            'nom_dns' => $validatedData['nom_dns'],
            'sys_exp_dev' => $validatedData['sys_exp_dev'],
            'adr_serv_bd_dev' => $validatedData['adr_serv_bd_dev'],
            'sys_exp_bd_dev' => $validatedData['sys_exp_bd_dev'],
            'lang_deve_dev' => $validatedData['lang_deve_dev'],
            'critical_dev' => $this->cleanCriticalData($validatedData['critical_dev'] ?? []),
            'statut_dev' => $validatedData['statut_dev'],
            'url_dev' => $validatedData['url_dev'],
            'vers_sys_dev' => $validatedData['vers_sys_dev'],
            'dist_sys_dev' => $validatedData['dist_sys_dev'],
            'nom_bd_dev' => $validatedData['nom_bd_dev'],
            'port_bd_dev' => $validatedData['port_bd_dev'],
            'user_bd_dev' => $validatedData['user_bd_dev'],
            'vers_lang_dev' => $validatedData['vers_lang_dev'],
            'fram_dev' => $validatedData['fram_dev'],
            'vers_fram_dev' => $validatedData['vers_fram_dev'],

            // PROD
            'env_prod' => $validatedData['env_prod'],
            'adr_serv_prod' => $validatedData['adr_serv_prod'],
            'sys_exp_prod' => $validatedData['sys_exp_prod'],
            'adr_serv_bd_prod' => $validatedData['adr_serv_bd_prod'],
            'sys_exp_bd_prod' => $validatedData['sys_exp_bd_prod'],
            'lang_deve_prod' => $validatedData['lang_deve_prod'],
            'critical_prod' => $this->cleanCriticalData($validatedData['critical_prod'] ?? []),
            'statut_prod' => $validatedData['statut_prod'],
            'url_prod' => $validatedData['url_prod'],
            'vers_sys_prod' => $validatedData['vers_sys_prod'],
            'dist_sys_prod' => $validatedData['dist_sys_prod'],
            'nom_bd_prod' => $validatedData['nom_bd_prod'],
            'port_bd_prod' => $validatedData['port_bd_prod'],
            'user_bd_prod' => $validatedData['user_bd_prod'],
            'vers_lang_prod' => $validatedData['vers_lang_prod'],
            'fram_prod' => $validatedData['fram_prod'],
            'vers_fram_prod' => $validatedData['vers_fram_prod'],

            // TEST
            'env_test' => $validatedData['env_test'],
            'adr_serv_test' => $validatedData['adr_serv_test'],
            'sys_exp_test' => $validatedData['sys_exp_test'],
            'adr_serv_bd_test' => $validatedData['adr_serv_bd_test'],
            'sys_exp_bd_test' => $validatedData['sys_exp_bd_test'],
            'lang_deve_test' => $validatedData['lang_deve_test'],
            'critical_test' => $this->cleanCriticalData($validatedData['critical_test'] ?? []),
            'statut_test' => $validatedData['statut_test'],
            'url_test' => $validatedData['url_test'],
            'vers_sys_test' => $validatedData['vers_sys_test'],
            'dist_sys_test' => $validatedData['dist_sys_test'],
            'nom_bd_test' => $validatedData['nom_bd_test'],
            'port_bd_test' => $validatedData['port_bd_test'],
            'user_bd_test' => $validatedData['user_bd_test'],
            'vers_lang_test' => $validatedData['vers_lang_test'],
            'fram_test' => $validatedData['fram_test'],
            'vers_fram_test' => $validatedData['vers_fram_test'],
        ];


        try {
            DB::table('catalogues')->where('id', $id)->update($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Application mise à jour avec succès.'
                ]);
            }

            return redirect()->back()->with('success', 'Application mise à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour catalogue: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour de l\'application.'
                ], 500);
            }

            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l\'application.');
        }
    }

    // vu que les services critiques sont en format JSON cette function se charge de les formater en simple array
    protected function cleanCriticalData(array $data): string
    {
        // Supprime les doublons, valeurs vides et espaces superflus
        $cleaned = array_unique(
            array_filter(
                array_map('trim', $data),
                fn($item) => !empty($item)
            )
        );

        return json_encode(array_values($cleaned)); // Réindexe le tableau
    }






    /**
     * Cette fonction servira à supprimer une application du catalogue
     */
    public function deleteCatalogue(Request $request, $id)
    {
        try {
            // Vérifier si l'application existe
            $catalogue = DB::table('catalogues')->where('id', $id)->first();

            if (!$catalogue) {
                return response()->json([
                    'success' => false,
                    'message' => 'Application introuvable.'
                ], 404);
            }

            // Suppression
            DB::table('catalogues')->where('id', $id)->delete();

            Log::info("Application supprimée : {$catalogue->app_name} (ID: {$id})");

            return response()->json([
                'success' => true,
                'message' => 'Application supprimée avec succès.'
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur suppression application : " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression.'
            ], 500);
        }
    }



    /**
     * Cette fonction servira à exporter l'ensemble du catalogue en format EXCEL
     */

    public function exportAll()
    {
        $allApps = DB::connection('mysql')->select('SELECT * FROM catalogues ORDER BY app_name ASC');
        return Excel::download(new CatalogueExport($allApps), 'catalogue_complet.xlsx');
    }



    public function faireDemande(Request $request)
    {

        $validatedData = $request->validate([
            'description' => 'nullable|string|max:255',
            'environnement' => 'required|in:DEV,TEST,PROD',
            'type_serveur' => 'nullable|in:physique,virtuel,cloud',
            'systeme_exploitation' => 'required|string|max:100',
            'version_os' => 'required|string|max:50',
            'architecture' => 'nullable|in:32-bit,64-bit',
            'ram_go' => 'required|integer|min:1',
            'stockage_go' => 'required|integer|min:1',
            'type_stockage' => 'nullable|in:HDD,SSD',
        ]);

        $data = [
            'description' => $validatedData['description'] ?? null,
            'user_id' => auth()->id(),
            'environnement' => $validatedData['environnement'],
            'type_serveur' => $validatedData['type_serveur'] ?? 'virtuel',
            'systeme_exploitation' => $validatedData['systeme_exploitation'],
            'version_os' => $validatedData['version_os'],
            'architecture' => $validatedData['architecture'] ?? '64-bit',
            'ram_go' => $validatedData['ram_go'],
            'stockage_go' => $validatedData['stockage_go'],
            'type_stockage' => $validatedData['type_stockage'] ?? 'SSD',
        ];


        try {
            // Insertion et récupération de l'ID
            $demandeId = DB::table('demande_serveur')->insertGetId($data);
            $data['id'] = $demandeId; // Ajout de l'ID pour la notification

            return $request->ajax()
                ? response()->json(['success' => true, 'message' => 'Demande de serveur créée avec succès.'])
                : redirect()->back()->with('success', 'Demande de serveur créée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur création demande serveur: ' . $e->getMessage() . ' ligne: ' . $e->getLine());
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => $e->getMessage()], 500)
                : redirect()->back()->with('error', 'Erreur lors de la création.');
        }
    }
}
