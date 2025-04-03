<?php

/* 
 * Project Name: onelab.gov.ph * 
 * Copyright(C)2017 Department of Science & Technology -IX * 
 * 12 16, 17 , 7:42:15 PM * 
 * Module: _routes * 
 */
return [
    //'admin/profile/view/<id:>' => 'admin/role/view', //admin/role/view?id=admin
    '<controller:\w+>/<id:\d+>' => '<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
];
