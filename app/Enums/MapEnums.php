<?php

namespace App\Enums;


/**
 * Class MapEnums
 *
 * This class defines file-related enumerations, such as file types and their corresponding icons.
 *
 * @package App\Enums
 */

enum MapEnums
{
    const EnumsMap = [
        'FileTypes' => GeneralEnums::FileTypes,
        'InfoPageTypes' => GeneralEnums::InfoPageTypes,
        'ContactMessageTypes' => GeneralEnums::ContactMessageTypes,
        'ContactMessageStatuses' => GeneralEnums::ContactMessageStatuses,
        'PropertySaleType' => GeneralEnums::PropertySaleType,
        'Currencies' => GeneralEnums::Currencies,
        'PermissionActions' => GeneralEnums::PermissionActions,
        'ProjectStatuses' => GeneralEnums::ProjectStatuses,
        'SubsidiaryTypes' => GeneralEnums::SubsidiaryTypes,
    ];
}
