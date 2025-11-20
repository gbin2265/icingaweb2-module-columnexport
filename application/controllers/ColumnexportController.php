<?php

/** ColumnExport v2.0 - Refactored **/

namespace Icinga\Module\Columnexport\Controllers;

use Icinga\Module\Icingadb\Web\Controller;
use ipl\Web\Url;
use ipl\Html\Html;

class ColumnexportController extends Controller
{
    /**
     * Supported export types with their corresponding icons
     */
    private const EXPORT_TYPES = [
        'csv' => 'icon-file-excel',
        'json' => 'icon-doc-text',
        'pdf' => 'icon-file-pdf',
        'sql' => 'icon-database'
    ];

    /**
     * Cached configuration entries
     */
    private array $configEntries = [];

    /**
     * Main action for column export page
     */
    public function columnexportAction(): void
    {
        $pageType = $this->getPageType();
        
        $this->addTitleTab(sprintf(t('Export %s'), $pageType));
        
        $this->loadConfiguration($pageType);
        
        foreach (array_keys(self::EXPORT_TYPES) as $exportType) {
            $this->renderExportSection($exportType);
        }
    }

    /**
     * Get the page type from URL parameters
     */
    private function getPageType(): string
    {
        return strtolower($this->params->get('pagetype', ''));
    }

    /**
     * Load and filter configuration entries for the given page type
     */
    private function loadConfiguration(string $pageType): void
    {
        $config = $this->Config();
        $this->configEntries = [];

        foreach ($config as $section) {
            $urlType = strtolower($section->get('urltype', ''));
            
            if ($urlType === $pageType) {
                $this->configEntries[] = [
                    'title' => $section->get('title'),
                    'urltype' => $urlType,
                    'exporttype' => strtolower($section->get('exporttype', '')),
                    'columns' => $section->get('columns')
                ];
            }
        }
    }

    /**
     * Render export section for a specific export type
     */
    private function renderExportSection(string $exportType): void
    {
        $div = Html::tag('div', ['class' => 'content']);
        $div->add(Html::tag('h2', Html::tag('u', strtoupper($exportType))));

        $entries = $this->getEntriesByExportType($exportType);
        
        foreach ($entries as $entry) {
            $div->add($this->createExportLink($entry, $exportType));
        }

        $this->addContent($div);
    }

    /**
     * Filter configuration entries by export type
     */
    private function getEntriesByExportType(string $exportType): array
    {
        return array_filter(
            $this->configEntries,
            fn($entry) => $entry['exporttype'] === $exportType
        );
    }

    /**
     * Create an export link HTML element
     */
    private function createExportLink(array $entry, string $exportType): object
    {
        $url = $this->buildExportUrl($entry, $exportType);
        $content = $this->buildLinkContent($entry);
        $icon = self::EXPORT_TYPES[$exportType] ?? 'icon-file-excel';

        return Html::tag('li', null, 
            Html::tag('a', [
                'href' => $url,
                'target' => '_blank',
                'class' => $icon
            ], $content)
        );
    }

    /**
     * Build the export URL with appropriate parameters
     */
    private function buildExportUrl(array $entry, string $exportType): string
    {
        $urlBase = Url::fromRequest()->getBasePath();
        $pageType = $this->getPageType();
        $params = Url::fromRequest()->getParams();
        
        // Remove unnecessary parameters
        $cleanParams = $params->without('columns', 'pagetype', 'format');
        
        // Add columns if specified in config
        if (!empty($entry['columns'])) {
            $cleanParams->set('columns', $entry['columns']);
        }
        
        // Add format parameter
        $cleanParams->set('format', $exportType);
        
        return sprintf('%s/%s?%s', $urlBase, $pageType, $cleanParams->toString());
    }

    /**
     * Build the link content text
     */
    private function buildLinkContent(array $entry): string
    {
        $title = $entry['title'];
        $columns = $entry['columns'];

        if (!empty($columns)) {
            return sprintf('%s (columns=%s)', $title, $columns);
        }

        return $title;
    }
}
