<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'site.title',
                'display_name' => 'Site Title',
                'value' => 'E-Shop',
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Site',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'site.description',
                'display_name' => 'Site Description',
                'value' => 'Sistema de administración de ventas web',
                'details' => '',
                'type' => 'text',
                'order' => 2,
                'group' => 'Site',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'site.logo',
                'display_name' => 'Site Logo',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 3,
                'group' => 'Site',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'site.google_analytics_tracking_id',
                'display_name' => 'Google Analytics Tracking ID',
                'value' => NULL,
                'details' => '',
                'type' => 'text',
                'order' => 8,
                'group' => 'Site',
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'admin.bg_image',
                'display_name' => 'Admin Background Image',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 4,
                'group' => 'Admin',
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'admin.title',
                'display_name' => 'Admin Title',
                'value' => 'E-Shop',
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Admin',
            ),
            6 => 
            array (
                'id' => 7,
                'key' => 'admin.description',
                'display_name' => 'Admin Description',
                'value' => 'Sistema de administración de ventas web',
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Admin',
            ),
            7 => 
            array (
                'id' => 8,
                'key' => 'admin.loader',
                'display_name' => 'Admin Loader',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 2,
                'group' => 'Admin',
            ),
            8 => 
            array (
                'id' => 9,
                'key' => 'admin.icon_image',
                'display_name' => 'Admin Icon Image',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 3,
                'group' => 'Admin',
            ),
            9 => 
            array (
                'id' => 10,
                'key' => 'admin.google_analytics_client_id',
            'display_name' => 'Google Analytics Client ID (used for admin dashboard)',
                'value' => NULL,
                'details' => '',
                'type' => 'text',
                'order' => 5,
                'group' => 'Admin',
            ),
            10 => 
            array (
                'id' => 11,
                'key' => 'site.phones',
                'display_name' => 'Phones',
                'value' => '',
                'details' => NULL,
                'type' => 'text',
                'order' => 4,
                'group' => 'Site',
            ),
            11 => 
            array (
                'id' => 12,
                'key' => 'site.address',
                'display_name' => 'Address',
                'value' => '',
                'details' => NULL,
                'type' => 'text',
                'order' => 6,
                'group' => 'Site',
            ),
            12 => 
            array (
                'id' => 13,
                'key' => 'site.email',
                'display_name' => 'Email',
                'value' => '',
                'details' => NULL,
                'type' => 'text',
                'order' => 7,
                'group' => 'Site',
            ),
            13 => 
            array (
                'id' => 14,
                'key' => 'social.whatsapp',
                'display_name' => 'Whatsapp',
                'value' => '',
                'details' => NULL,
                'type' => 'text',
                'order' => 9,
                'group' => 'Social',
            ),
            14 => 
            array (
                'id' => 15,
                'key' => 'social.facebook',
                'display_name' => 'Facebook',
                'value' => '',
                'details' => NULL,
                'type' => 'text',
                'order' => 10,
                'group' => 'Social',
            ),
            15 => 
            array (
                'id' => 16,
                'key' => 'social.instagram',
                'display_name' => 'Instagram',
                'value' => '',
                'details' => NULL,
                'type' => 'text',
                'order' => 11,
                'group' => 'Social',
            ),
            16 => 
            array (
                'id' => 17,
                'key' => 'social.youtube',
                'display_name' => 'Youtube',
                'value' => '',
                'details' => NULL,
                'type' => 'text',
                'order' => 12,
                'group' => 'Social',
            ),
            17 => 
            array (
                'id' => 18,
                'key' => 'social.twitter',
                'display_name' => 'Twitter',
                'value' => '',
                'details' => NULL,
                'type' => 'text',
                'order' => 13,
                'group' => 'Social',
            ),
        ));
        
        
    }
}