<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CatalogueExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, ShouldAutoSize, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Nom Application',
            'Description',
            'URL Application',
            'URL Documentation',
            'URL Git',
            'Environnement Type', // DEV, TEST, PROD
            'URL Environnement',
            'Adresse Serveur',
            'Nom DNS', // NOUVEAU: Champ nom_dns pour DEV
            'Sys Exp Serveur',
            'Distribution Sys Exp Serveur',
            'Version Sys Exp Serveur',
            'Adresse Base de données',
            'Base de Données', // Clarifié pour correspondre à sys_exp_bd_dev/test/prod
            'Nom de la Base de Données',
            'Port Base de Données',
            'Utilisateur Base de Données',
            'Langage de programmation',
            'Version Langage',
            'Framework',
            'Version Framework',
            'Services critiques',
            'Statut'
        ];
    }

    public function map($catalogue): array
    {
        // Cette méthode est requise par FromMapping mais nous allons tout gérer dans registerEvents
        // car nous créons plusieurs lignes par élément de collection.
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style de l'en-tête
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => '000000']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FCF000']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN
                    ]
                ]
            ],
            // Alignement général pour toutes les colonnes utilisées (A à W)
            'A:W' => [ // Ajusté pour inclure la nouvelle colonne Nom DNS
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_TOP,
                    'wrapText' => true
                ]
            ],
            // Styles des URLs (colonnes C, D, E, et maintenant G pour URL Environnement)
            'C:E' => [ // Pour URL Application, Doc, Git
                'font' => [
                    'color' => ['rgb' => '0563C1'],
                    'underline' => true
                ]
            ],
            'G' => [ // Pour URL Environnement
                'font' => [
                    'color' => ['rgb' => '0563C1'],
                    'underline' => true
                ]
            ],
            // Style des services critiques (colonne V)
            'V' => [ // Ajusté de U à V
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => Alignment::VERTICAL_TOP
                ]
            ]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // Nom Application
            'B' => 30, // Description
            'C' => 25, // URL Application
            'D' => 25, // URL Documentation
            'E' => 25, // URL Git
            'F' => 15, // Environnement Type
            'G' => 25, // URL Environnement
            'H' => 20, // Adresse Serveur
            'I' => 20, // NOUVEAU: Nom DNS
            'J' => 15, // OS Serveur
            'K' => 20, // Distribution OS Serveur
            'L' => 15, // Version OS Serveur
            'M' => 20, // Adresse BD
            'N' => 15, // OS Base de Données
            'O' => 20, // Nom de la BD
            'P' => 10, // Port BD
            'Q' => 20, // Utilisateur BD
            'R' => 20, // Langage de programmation
            'S' => 15, // Version Langage
            'T' => 20, // Framework
            'U' => 15, // Version Framework
            'V' => 30, // Services critiques
            'W' => 15  // Statut
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $rowIndex = 2; // Commence après l'en-tête

                foreach ($this->data as $catalogue) {
                    $environnements = [
                        'DEV' => [
                            'url' => $catalogue->url_dev,
                            'env_name' => $catalogue->env_dev,
                            'server' => $catalogue->adr_serv_dev,
                            'nom_dns' => $catalogue->nom_dns, // NOUVEAU: Champ nom_dns pour DEV
                            'os_server' => $catalogue->sys_exp_dev,
                            'dist_sys' => $catalogue->dist_sys_dev,
                            'vers_sys' => $catalogue->vers_sys_dev,
                            'db' => $catalogue->adr_serv_bd_dev,
                            'os_db' => $catalogue->sys_exp_bd_dev,
                            'nom_bd' => $catalogue->nom_bd_dev,
                            'port_bd' => $catalogue->port_bd_dev,
                            'user_bd' => $catalogue->user_bd_dev,
                            'lang' => $catalogue->lang_deve_dev,
                            'vers_lang' => $catalogue->vers_lang_dev,
                            'fram' => $catalogue->fram_dev,
                            'vers_fram' => $catalogue->vers_fram_dev,
                            'critical' => $catalogue->critical_dev,
                            'status' => $catalogue->statut_dev
                        ],
                        'TEST' => [
                            'url' => $catalogue->url_test,
                            'env_name' => $catalogue->env_test,
                            'server' => $catalogue->adr_serv_test,
                            'nom_dns' => null, // Pas de nom_dns pour TEST
                            'os_server' => $catalogue->sys_exp_test,
                            'dist_sys' => $catalogue->dist_sys_test,
                            'vers_sys' => $catalogue->vers_sys_test,
                            'db' => $catalogue->adr_serv_bd_test,
                            'os_db' => $catalogue->sys_exp_bd_test,
                            'nom_bd' => $catalogue->nom_bd_test,
                            'port_bd' => $catalogue->port_bd_test,
                            'user_bd' => $catalogue->user_bd_test,
                            'lang' => $catalogue->lang_deve_test,
                            'vers_lang' => $catalogue->vers_lang_test,
                            'fram' => $catalogue->fram_test,
                            'vers_fram' => $catalogue->vers_fram_test,
                            'critical' => $catalogue->critical_test,
                            'status' => $catalogue->statut_test
                        ],
                        'PROD' => [
                            'url' => $catalogue->url_prod,
                            'env_name' => $catalogue->env_prod,
                            'server' => $catalogue->adr_serv_prod,
                            'nom_dns' => null, // Pas de nom_dns pour PROD
                            'os_server' => $catalogue->sys_exp_prod,
                            'dist_sys' => $catalogue->dist_sys_prod,
                            'vers_sys' => $catalogue->vers_sys_prod,
                            'db' => $catalogue->adr_serv_bd_prod,
                            'os_db' => $catalogue->sys_exp_bd_prod,
                            'nom_bd' => $catalogue->nom_bd_prod,
                            'port_bd' => $catalogue->port_bd_prod,
                            'user_bd' => $catalogue->user_bd_prod,
                            'lang' => $catalogue->lang_deve_prod,
                            'vers_lang' => $catalogue->vers_lang_prod,
                            'fram' => $catalogue->fram_prod,
                            'vers_fram' => $catalogue->vers_fram_prod,
                            'critical' => $catalogue->critical_prod,
                            'status' => $catalogue->statut_prod
                        ]
                    ];

                    $firstRowForApp = true;
                    $rowSpan = count($environnements);

                    foreach ($environnements as $envType => $envData) {
                        // Écrire les données communes seulement sur la première ligne de l'application
                        if ($firstRowForApp) {
                            $sheet->setCellValue('A' . $rowIndex, $this->formatText($catalogue->app_name));
                            $sheet->setCellValue('B' . $rowIndex, $this->formatText($catalogue->desc_app));
                            $sheet->setCellValue('C' . $rowIndex, $this->formatUrl($catalogue->url_app));
                            $sheet->setCellValue('D' . $rowIndex, $this->formatUrl($catalogue->url_doc));
                            $sheet->setCellValue('E' . $rowIndex, $this->formatUrl($catalogue->url_git));
                        }

                        // Détails de l'environnement
                        $sheet->setCellValue('F' . $rowIndex, $envType); // Type d'environnement (DEV, TEST, PROD)
                        $sheet->setCellValue('G' . $rowIndex, $this->formatUrl($envData['url'])); // URL Environnement
                        $sheet->setCellValue('H' . $rowIndex, $this->formatText($envData['server'])); // Adresse Serveur
                        $sheet->setCellValue('I' . $rowIndex, $this->formatText($envData['nom_dns'])); // NOUVEAU: Nom DNS
                        $sheet->setCellValue('J' . $rowIndex, $this->formatText($envData['os_server'])); // OS Serveur
                        $sheet->setCellValue('K' . $rowIndex, $this->formatText($envData['dist_sys'])); // Distribution OS Serveur
                        $sheet->setCellValue('L' . $rowIndex, $this->formatText($envData['vers_sys'])); // Version OS Serveur
                        $sheet->setCellValue('M' . $rowIndex, $this->formatText($envData['db'])); // Adresse BD
                        $sheet->setCellValue('N' . $rowIndex, $this->formatText($envData['os_db'])); // OS BD
                        $sheet->setCellValue('O' . $rowIndex, $this->formatText($envData['nom_bd'])); // Nom de la BD
                        $sheet->setCellValue('P' . $rowIndex, $this->formatText($envData['port_bd'])); // Port BD
                        $sheet->setCellValue('Q' . $rowIndex, $this->formatText($envData['user_bd'])); // Utilisateur BD
                        $sheet->setCellValue('R' . $rowIndex, $this->formatText($envData['lang'])); // Langage de programmation
                        $sheet->setCellValue('S' . $rowIndex, $this->formatText($envData['vers_lang'])); // Version Langage
                        $sheet->setCellValue('T' . $rowIndex, $this->formatText($envData['fram'])); // Framework
                        $sheet->setCellValue('U' . $rowIndex, $this->formatText($envData['vers_fram'])); // Version Framework
                        $sheet->setCellValue('V' . $rowIndex, $this->formatJson($envData['critical'])); // Services critiques
                        $sheet->setCellValue('W' . $rowIndex, $this->formatStatus($envData['status'])); // Statut

                        // Style des bordures pour la ligne actuelle
                        $styleArray = [
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['rgb' => '000'],
                                ],
                            ],
                        ];
                        $sheet->getStyle('A' . $rowIndex . ':W' . $rowIndex)->applyFromArray($styleArray); // Ajusté de V à W

                        // Fusionner les cellules communes si nécessaire (pour les colonnes A à E)
                        if ($firstRowForApp && $rowSpan > 1) {
                            foreach (['A', 'B', 'C', 'D', 'E'] as $col) {
                                $sheet->mergeCells($col . $rowIndex . ':' . $col . ($rowIndex + $rowSpan - 1));
                            }
                            $firstRowForApp = false;
                        }

                        // Appliquer un fond différent pour chaque application (sur toutes ses lignes d'environnement)
                        if ($envType === 'DEV' && ($catalogue->id % 2 === 0)) {
                            $sheet->getStyle('A' . $rowIndex . ':W' . ($rowIndex + $rowSpan - 1)) // Ajusté de V à W
                                ->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()
                                ->setRGB('F5F5F5'); // Couleur plus claire pour l'alternance
                        }

                        $rowIndex++;
                    }
                }

                // Geler la première ligne (en-tête)
                $sheet->freezePane('A2');
            },
        ];
    }

    // Méthodes de formatage conservées et ajustées
    protected function formatText($value)
    {
        return $value ?? '-';
    }

    protected function formatUrl($value)
    {
        // Utilise HYPERLINK pour créer des liens cliquables dans Excel
        return $value ? '=HYPERLINK("' . $value . '", "' . str_replace('"', '""', $value) . '")' : '-';
    }

    protected function formatJson($value)
    {
        if (empty($value)) {
            return '-';
        }

        $decoded = json_decode($value, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Si ce n'est pas un JSON valide, retourne la valeur brute
            return $value;
        }

        // Si c'est un tableau simple de strings (comme les services critiques)
        if (is_array($decoded) && array_keys($decoded) === range(0, count($decoded) - 1)) {
            return implode(', ', $decoded);
        }

        // Si c'est un objet ou un tableau associatif, formatte-le
        $formatted = [];
        foreach ($decoded as $key => $val) {
            $formatted[] = "• " . ucfirst(str_replace('_', ' ', $key)) . ": " . (is_array($val) ? implode(', ', $val) : $val);
        }
        return implode("\n", $formatted);
    }

    protected function formatStatus($value)
    {
        if (empty($value)) {
            return '-';
        }
        return $value;
    }
}
