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

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class CatalogueController extends Controller
{
    /**Cette fonction servira à recupérer l'ensemble des données pour les afficher dans la vue */
    /**
     * Cette fonction servira à récupérer l'ensemble des données pour les afficher dans la vue
     */
    public function getCatalogue()
    {
        $catalogue = DB::table('catalogues')
            ->orderBy('app_name', 'ASC')
            ->paginate(3);


        $recentSearches = DB::table('search_histories')
            ->where('user_session', Session::getId())
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('pages.catalogue.application', [
            'catalogue' => $catalogue,
            'recent_searches' => $recentSearches,
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
        $results = [];

        if (!empty($searchQuery)) {
            $lowerSearch = strtolower($searchQuery);
            $results = DB::connection('mysql')->select(
                'SELECT * FROM catalogues
        WHERE LOWER(app_name) LIKE ?
        OR LOWER(url_app) LIKE ?
        OR LOWER(url_doc) LIKE ?
        OR LOWER(url_git) LIKE ?
        OR LOWER(adr_serv_dev) = ?
        OR LOWER(adr_serv_test) = ?
        OR LOWER(adr_serv_prod) LIKE ?',
                [
                    '%' . $lowerSearch . '%',
                    '%' . $lowerSearch . '%',
                    '%' . $lowerSearch . '%',
                    '%' . $lowerSearch . '%',
                    $lowerSearch,
                    $lowerSearch,
                    '%' . $lowerSearch . '%'
                ]
            );
            // ✅ Enregistrement de l'historique, même si AJAX
            SearchHistory::create([
                'search_term' => $searchQuery,
                'user_ip' => $request->ip(),
                'user_session' => session()->getId(),
                'results_count' => count($results),
            ]);
        }



        $recentSearches = $this->getRecentSearchesData();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $results,
                'recent_searches' => $recentSearches,
                'query' => $searchQuery
            ]);
        }




        return view('pages.catalogue.application', [
            'catalogue' => collect($results),
            'search_query' => $searchQuery,
            'recent_searches' => $recentSearches
        ]);
    }

    // Méthodes utilitaires privées
    public function getRecentSearchesData()
    {
        return session()->getId()
            ? SearchHistory::getRecentSearches(session()->getId())
            : [];
    }



    /**
     * Nettoie et formate les données critiques
     */



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




    public function getRecentSearches(Request $request)
    {
        $recentSearches = [];

        if (session()->getId()) {
            $recentSearches = SearchHistory::where('user_session', session()->getId())
                ->select('search_term', DB::raw('MAX(results_count) as results_count'))
                ->groupBy('search_term')
                ->orderBy('created_at', 'desc')
                ->limit(15)
                ->get();
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'recent_searches' => $recentSearches
            ]);
        }

        return $recentSearches;
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
     * Cette fonction servira à vider complètement l'historique de recherche pour la session courante
     */
    public function clearSearchHistory(Request $request)
    {
        try {
            if (!session()->getId()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Session non trouvée.'
                    ], 400);
                }

                return redirect()->back()->with('error', 'Session non trouvée.');
            }

            // Supprimer tout l'historique pour cette session
            $deleted = SearchHistory::where('user_session', session()->getId())->delete();

            if ($deleted > 0) {
                // Log de l'action de suppression
                Log::info('Historique de recherche vidé pour la session: ' . session()->getId() . ' (' . $deleted . ' entrées supprimées)');

                // Vérifier si c'est une requête AJAX
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Historique de recherche vidé avec succès.',
                        'deleted_count' => $deleted
                    ]);
                }

                // Ajout du message flash pour SweetAlert2
                return redirect()->back()->with('success', 'Historique de recherche vidé avec succès.');
            } else {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'L\'historique était déjà vide.',
                        'deleted_count' => 0
                    ]);
                }

                return redirect()->back()->with('info', 'L\'historique était déjà vide.');
            }
        } catch (\Exception $e) {
            Log::error('Erreur vidage historique de recherche: ' . $e->getMessage());

            // Vérifier si c'est une requête AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors du vidage de l\'historique.'
                ], 500);
            }

            // Ajout du message flash pour SweetAlert2
            return redirect()->back()->with('error', 'Erreur lors du vidage de l\'historique.');
        }
    }

    public function exportAll()
    {
        $allApps = DB::connection('mysql')->select('SELECT * FROM catalogues ORDER BY app_name ASC');
        return Excel::download(new CatalogueExport($allApps), 'catalogue_complet.xlsx');
    }
    /**
     * Exporte les applications filtrées en Excel
     */
    public function exportFiltered(Request $request)
    {
        $searchQuery = $request->get('search_query', '');

        if (empty($searchQuery)) {
            return $this->exportAll();
        }

        $lowerSearch = strtolower($searchQuery);
        $results = DB::connection('mysql')->select(
            '
        SELECT app_name ,
        desc_app
        url_app ,
        url_doc ,
        url_git ,,
        env_dev ,
        adr_serv_dev  ,
        sys_exp_dev ,
        adr_serv_bd_dev ,
        sys_exp_bd_dev ,
        lang_deve_dev ,
        critical_dev ,
        statut_dev ,

        env_prod ,
        adr_serv_prod ,
        sys_exp_prod ,
        adr_serv_bd_prod ,
        sys_exp_bd_prod ,
        lang_deve_prod ,
        critical_prod ,
        statut_prod ,

        env_test ,
        adr_serv_test ,
        sys_exp_test ,
        adr_serv_bd_test ,
        sys_exp_bd_test ,
        lang_deve_test ,
        critical_test ,
        statut_test   FROM catalogues
        WHERE LOWER(app_name) LIKE ?
        OR LOWER(url_app) LIKE ?
        OR LOWER(url_doc) LIKE ?
        OR LOWER(url_git) LIKE ?
        OR LOWER(adr_serv_dev) = ?
        OR LOWER(adr_serv_test) = ?
        OR LOWER(adr_serv_prod) LIKE ?',
            [
                '%' . $lowerSearch . '%',
                '%' . $lowerSearch . '%',
                '%' . $lowerSearch . '%',
                '%' . $lowerSearch . '%',
                $lowerSearch,
                $lowerSearch,
                '%' . $lowerSearch . '%'
            ]
        );

        $filename = 'catalogue_filtre_' . str_replace(' ', '_', $searchQuery) . '.xlsx';
        return Excel::download(new CatalogueExport($results), $filename);
    }
}