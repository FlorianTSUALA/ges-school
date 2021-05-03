<?php

namespace Config\Invariant;


/*
 * DEFINITION DE LA CLASSE CONCERNANTS LES TAGS D'API
 */
class API
{
    const TAG_STATUS = "status";
    const TAG_RESULT = "result";
    const TAG_REPORT = "report";
    const TAG_DATA = "data";
    const TAG_ORDER_BY = "orderBy";
    const TAG_LIMIT = "limit";
    const TAG_SUCCESS = 1;
    const TAG_ERROR = 0;

    //FOR DATATABLE
    const TAG_DATATABLE_DR = "draw";
    const TAG_DATATABLE_RT = "recordsTotal";
    const TAG_DATATABLE_RF = "recordsFiltered";

    const TAG_INTERVAL = "interval";
    const TAG_START_DATE = "start_date";
    const TAG_END_DATE = "end_date";

    const TAG_DATATABLE_VALUE_DR = 1;
    
    const REALTIME_TIME_RECENT_TRANSACTION= 400000;
    const REALTIME_TOTAL_CHART_TRANSACTION= 5;
    const REALTIME_CHART_TRANSACTION= 5000;
}