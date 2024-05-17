<?php
/* Icinga Web 2 | (c) 2013 Icinga Development Team | GPLv2+ */

namespace Icinga\Web\Widget\Tabextension;

use Icinga\Application\Platform;
use Icinga\Application\Hook;
use Icinga\Web\Url;
use Icinga\Web\Widget\Tab;
use Icinga\Web\Widget\Tabs;

/**
 * Tabextension that offers different output formats for the user in the dropdown area
 */
class ColumnExport implements Tabextension
{
    /**
     * JSON output type
     */
    const TYPE_JSON = 'json';

    /**
     * CSV output type
     */
    const TYPE_CSV = 'csv';

    /**
     * An array of tabs to be added to the dropdown area
     *
     * @var array
     */
    private $tabs = array();

    /**
     * Create a new ColumnExport extender
     *
     * In general, it's assumed that all types are supported when an outputFormat extension
     * is added, so this class offers to remove specific types instead of adding ones
     *
     * @param array $disabled An array of output types to <b>not</b> show.
     */
    public function __construct(array $disabled = array())
    {
        foreach ($this->getSupportedTypes() as $type => $tabConfig) {
            if (!in_array($type, $disabled)) {
                $tabConfig['url'] = Url::fromRequest()->getBasePath() . '/columnexport/columnexport/columnexport?' . Url::fromRequest()->getParams();
                $tab = new Tab($tabConfig);
                $tab->setBaseTarget('_next');
                $this->tabs[] = $tab;
            }
        }
    }

    /**
     * Applies the format selectio to the provided tabset
     *
     * @param   Tabs $tabs The tabs object to extend with
     *
     * @see     Tabextension::apply()
     */
    public function apply(Tabs $tabs)
    {
        foreach ($this->tabs as $tab) {
            $tabs->addAsDropdown($tab->getName(), $tab);
        }
    }

    /**
     * Return an array containing the tab definitions for all supported types
     *
     * Using array_keys on this array or isset allows to check whether a
     * requested type is supported
     *
     * @return  array
     */
    public function getSupportedTypes()
    {
        $supportedTypes = array();

        $supportedTypes[self::TYPE_CSV] = array(
            'name'      => 'Column Export',
            'label'     => 'Column Export',
            'icon'      => 'download',
            'urlParams' => array('pagetype' => Url::fromRequest()->getPath())
        );

        return $supportedTypes;
    }
}
