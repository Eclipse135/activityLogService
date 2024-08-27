<?php

namespace App\Enum;

enum ActivityLogType: string
{
    case USER_BUYS_PRODUCT = 'user_buys_product';
    case PRODUCT_GRANTED_TO_USER_VIA_ADMIN_PANEL = 'product_granted_to_user_via_admin_panel';
    case ADMIN_EDITED_PRODUCT = 'admin_edited_product';
}
