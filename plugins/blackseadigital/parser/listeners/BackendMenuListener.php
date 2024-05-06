<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Listeners;

use Backend\Classes\NavigationManager;
use October\Rain\Events\Dispatcher;
use System\Classes\SettingsManager;

class BackendMenuListener
{
    public function subscribe(Dispatcher $event): void
    {
        $event->listen('backend.menu.extendItems', function (NavigationManager $manage) {
            $manage->removeMainMenuItem('October.Editor', 'editor');
            $manage->removeMainMenuItem('October.Media', 'media');
        });

        $event->listen('system.settings.extendItems', function (SettingsManager $manager) {
            $manager->removeSettingItem('October.Cms', 'Theme');
            $manager->removeSettingItem('October.Cms', 'Maintenance_Settings');
            $manager->removeSettingItem('October.System', 'Updates');
            $manager->removeSettingItem('October.System', 'My_Updates');
            $manager->removeSettingItem('October.System', 'Mail_Templates');
            $manager->removeSettingItem('October.System', 'Mail_settings');
            $manager->removeSettingItem('October.System', 'Mail_Brand_Settings');
            $manager->removeSettingItem('October.System', 'Sites');
            $manager->removeSettingItem('October.Backend', 'Editor');
            $manager->removeSettingItem('October.Backend', 'Branding');
            $manager->removeSettingItem('October.Backend', 'Administrators');
            $manager->removeSettingItem('October.Backend', 'AdminRoles');
            $manager->removeSettingItem('October.Backend', 'AdminGroups');
        });
    }
}
