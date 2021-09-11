$data['reduction'] =  GroupeFamilialReduction::table()->select()->where('annee_scolaire_id', $annee_scolaire_id)->where('groupe_familial_id', $groupe_familial_id)->where('visibilite', 1)->one();

$results[API::TAG_STATUS] = API::TAG_SUCCESS;
$results[API::TAG_DATATABLE_DR] = API::TAG_DATATABLE_VALUE_DR;
$results[API::TAG_DATATABLE_RT] = count($data);
$results[API::TAG_DATATABLE_RF] = count($data);
$results[API::TAG_DATA] = $data;

echo Helpers::toJSON($results) 