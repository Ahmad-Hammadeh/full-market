<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Setting;

class CustomSettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $setting = $this->findSetting('site.stock_threshold');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('backend.stock_threshold'),
                'value'        => 5,
                'details'      => '',
                'type'         => 'text',
                'order'        => 6,
                'group'        => 'Site',
            ])->save();
        }


    }

    /**
     * [setting description].
     *
     * @param [type] $key [description]
     *
     * @return [type] [description]
     */
    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}
