<?php

namespace app\models\Forms;

/**
 * Description of CatalogAddressForm
 *
 * @author kotov
 */
class CatalogAddressForm extends \yii\base\Model
{
    public string $area; //Регион / область
    public string $city; // Город
    public string $address; // Адрес
    public string $index; // Индекс
    public string $area_eng; // Регион / область (ENG)
    public string $city_eng; // Город (ENG)
    public string $address_eng; // Адрес (ENG)
    public string $zip_code; // Индекс (ENG)
    
    public function rules(): array
    {
        return [
            [['area', 'city','address', 'index','area_eng', 'city_eng','address_eng', 'zip_code'], 'string'],
            [['area', 'city','address', 'index','area_eng', 'city_eng','address_eng', 'zip_code'], 'trim'],
            //[['area', 'city','address', 'index','area_eng', 'city_eng','address_eng', 'zip_code'], ],
        ];
    }
}
