<?php

namespace Config\Invariant;

class Query
{
    
    const OPERATOR = "OPERATOR";
    const CLAUSE_RIGHT = "RIGHT";
    const CLAUSE_LEFT = "LEFT";

    const OPERATOR_NOT = " NOT ";
    const OPERATOR_EQUAL = " = ";
    const OPERATOR_NOT_EQUAL = " <> ";
    const OPERATOR_SUP = " > ";
    const OPERATOR_INF = " < ";
    const OPERATOR_EQUAL_INF = " <= ";
    const OPERATOR_EQUAL_SUP = " >= ";

    const JOIN_TYPE = "TYPE";
    const JOIN_TABLE = "TABLE";
    const JOIN_CLAUSE = "CLAUSE";

    const TAG_CONDITION = "CONDITION";
    const TAG_CLAUSE_ARRAY = "CLAUSE_ARRAY";


    const ALIAS = " AS ";
    const COLUMN = "COLUMN";
    const TAG_ALIAS = "ALIAS";
    const TAG_FUNCTION = "FUNCTION";
    const TAG_INTERVAL_WIDTH = "interval";
    const TAG_INTERVAL_PERIOD = "period";


    const CONNECTOR = "CONNECTOR";
    const CONNECTOR_AND = " AND ";
    const CONNECTOR_OR = " OR ";

    const ORDER_DESC = " DESC ";
    const ORDER_ASC = " ASC ";

    const SELECTOR_ALL = " * ";

    const OPERATOR_BETWEEN = " BETWEEN ";
    const OPERATOR_LIKE = " LIKE ";

    const FILTER_DISTINCT = " DISTINCT ";

    const FUNC_COUNT = " COUNT ";
    const TAG_FUNC_COUNT = "Nombre";
    const FUNC_AVG = " AVG ";
    const FUNC_SUM = " SUM ";
    const TAG_FUNC_SUM = "Montant";
    const FUNC_MIN = " MIN ";
    const FUNC_MAX = " MAX ";

    const SEPARATOR_COMMA = " , ";
    const SEPARATOR_ESCAPE = "  ";


    const FUNCTION_SUM = "SUM";
    const FUNCTION_MIN = "MIN";
    const FUNCTION_MAX = "MAX";
    const FUNCTION_COUNT = "COUNT";
    const FUNCTION_AVG = "AVG";

    const INTERVAL_PERIOD_YEAR = "YEAR";
    const INTERVAL_PERIOD_MONTH = "MONTH";
    const INTERVAL_PERIOD_DAY = "DAY";
    const INTERVAL_PERIOD_HOUR = "HOUR";
    const INTERVAL_PERIOD_MINUTE = "MINUTE";
    const INTERVAL_PERIOD_SECONDE = "SECONDE";

    const JOIN_LEFT = "LEFT JOIN";
    const JOIN_RIGHT = "RIGHT JOIN";
}