<?php

return [

    'urls'      => [
        
        'base'            => 'http://download.geonames.org/export/dump/',
        
        'feature_codes'   => 'featureCodes_{locale}.txt',
        
        'country'         => '{country}.zip',
        'country_info'    => 'countryInfo.zip',
        'hierarchy'       => 'hierarchy.zip',
        'shapes'          => 'shapes_simplified_low.zip',
        
        'cities'          => 'cities{size}.zip',
        'cities5000'      => 'cities5000.zip',
        'cities15000'     => 'cities15000.zip',
        
        'alternate_names' => [
            'base'          => 'alternateNames.zip',
            'modifications' => 'alternateNamesModifications-{date}.txt',
            'deletions'     => 'alternateNamesDeletes-{date}.txt',
        ],

        'admin1_codes'    => 'admin1CodesASCII.txt',
        'admin2_codes'    => 'admin2Codes.txt',
        
        'timezones'       => 'timeZones.txt',
        'languages'       => 'iso-languagecodes.txt',
        
        'modifications'   => 'modifications-{date}.txt',
        'deletions'       => 'deletes-{date}.txt',
    ],

    'available' => [

        'feature_code_locales' => [
            //'en', // Already included as base locale
            'bg','nb','nn','no','ru','sv',
        ],

        'cities_sizes' => [
            '1000', '5000', '15000',
        ],

        'countries' => [
            'AD','AE','AF','AG','AI','AL','AM','AO','AQ','AR','AS','AT','AU','AW','AX','AZ',
            'BA','BB','BD','BE','BF','BG','BH','BI','BJ','BL','BM','BN','BO','BQ','BR','BS',
            'BT','BV','BW','BY','BZ','CA','CC','CD','CF','CG','CH','CI','CK','CL','CM','CN',
            'CO','CR','CS','CU','CV','CW','CX','CY','CZ','DE','DJ','DK','DM','DO','DZ','EC',
            'EE','EG','EH','ER','ES','ET','FI','FJ','FK','FM','FO','FR','GA','GB','GD','GE',
            'GF','GG','GH','GI','GL','GM','GN','GP','GQ','GR','GS','GT','GU','GW','GY','HK',
            'HM','HN','HR','HT','HU','ID','IE','IL','IM','IN','IO','IQ','IR','IS','IT','JE',
            'JM','JO','JP','KE','KG','KH','KI','KM','KN','KP','KR','KW','KY','KZ','LA','LB',
            'LC','LI','LK','LR','LS','LT','LU','LV','LY','MA','MC','MD','ME','MF','MG','MH',
            'MK','ML','MM','MN','MO','MP','MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ',
            'NA','NC','NE','NF','NG','NI','NL','NO','NP','NR','NU','NZ','OM','PA','PE','PF',
            'PG','PH','PK','PL','PM','PN','PR','PS','PT','PW','PY','QA','RE','RO','RS','RU',
            'RW','SA','SB','SC','SD','SE','SG','SH','SI','SJ','SK','SL','SM','SN','SO','SR',
            'SS','ST','SV','SX','SY','SZ','TC','TD','TF','TG','TH','TJ','TK','TL','TM','TN',
            'TO','TR','TT','TV','TW','TZ','UA','UG','UM','US','UY','UZ','VA','VC','VE','VG',
            'VI','VN','VU','WF','WS','XK','YE','YT','YU','ZA','ZM','ZW',
        ],

    ],
];
