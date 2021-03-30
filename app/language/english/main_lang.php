<?php defined('BASEPATH') or exit('No direct script access allowed');
####################################### -- SETTING --
//main direction for progtam set : [rtl] for right to left and [ltr] for right left
define("_DIRECTION", "ltr");
//setting for date mode : [sha] for shamsi and [ger] for gregorian
define("_DM", "ger"); 
//main name of program
define("_TITLE", "jet");
define("_TEXT", "fast like jet");
define("_S", "s ");
define("__", " ");
define("_WAITING", "please wait . . .");
define("_SS", "s ");
define("_SELECT", "select");

//main currency method $ or rial and ...
define("_R", "$");


####################################### -- GENERALS--
define("_DEFAULT", "default");
define("_HELLO", "hello");
define("_TITLE_TEXT", "title text");
define("_SPACE", "space");
define("_OK", "ok");
define("_NO", "no");
define("_YES", "yes");
define("_CANCEL", "cancel");
define("_BYE", "good bye");
define("_WELLCOME", "wellcome");
define("_USER", "admin");
define("_MAIL", "mail");
define("_FEMAIL", "femail");
define("_COUNTRYS", "countries");
define("_COUNTRY", "country");
define("_MANAGE_COUNTRIES", "manage country");
define("_CLOSE", "accept and close");
define("_CLOSE2", "close");
define("_ID", "id");
define("_AND", " and ");
define("_FILTER", "filter");
define("_CLEAR_FILTER", "clear filter");
define("_MANAGE", " manage ");
define("_ADD", " add ");
define("_SEND", "send");
define("_EDIT", " edit");
define("_DELETE", " delete ");
define("_JAME_KOL", "total");
define("_DEF_ELEMENT", "select");
define("_BUY", "sale");
define("_IP", "ip");
define("_SYSTEM_INFO", "system info");
define("_POST", "send");
define("_PROFILE", "your profile");
define("_INBOX", "inbox");
define("_ALL", " all ");
define("_OF", "of");
define("_RECORD", "record");
define("_CONTACT", " contact ");
define("_MORE", "more");

define("_PROJECT", "project");
define("_DUE_TIME", "due date");
define("_ALERT", "alert");
define("_TODAY", "today ");
define("_LIST", "list ");
define("_PAY", "pay ");
define("_ACOUNT", "account ");


define("_SAT", "saturday");
define("_SUN", "sunday");
define("_MON", "monday");
define("_TUS", "tuesday");
define("_WEN", "wednesday");
define("_THU", "Thursday");
define("_FRI", "friday");


define("_MAKER", "maker");
define("_PRINT", "proc_terminate");
define("_EXPIRE", "expire");
define("_DBLCLICK_TO_EDIT", "to change dbl-click");

define("_WARNING", "warning");
define("_ARE_YOU_SURE", "are you sure?");
define("_SEX", "sex");
define("_EMPLOY", "employer");
define("_EMPLOYs", "employers");
define("_PROMOTER", "promoter");
define("_KARSHENAS", "expert");
define("_KOL", "total"); // total
define("_FOROOSH", "sale"); // sale
define("_PERIOD", "period");
define("_DARIAFTI", "get");
define("_ALERT_IN_WEEK", "alert in week");

####################################### -- ALERTS --
define("_LOGIN_INVALID", "error in username and password");
define("_EDITED", " edited successful ");
define("_NEXT", "next");
define("_PREVIOUS", "previous");
define("_FIRST", "first");
define("_TRUE", "true");
define("_FALSE", "false");
define("_BILL", "bill");
define("_ERROR_IN_INPUT_PARAMS", "error in input patametrs.");
define("_ERROR_AJAX", "error in AJAX");
define("_ERROR_UPDATE", "error in update data");
define("_ERROR_DELETE", "error in delete data");
define("_ERROR_ADD", "error in add data");
define("_ASK_DELETE", "are you sure to delete?");
define("_ERROR_LIMIT_", "limitation error");
define("_ERROR", "error");

####################################### -- login --
define("_TITLE_LOGIN", "jet");
define("_WELLCOME_LOGIN", "wellcome");
define("_LOGIN", "login");
define("_REGISTER", "register");
define("_USERNAME", "username");
define("_PASSWORD", "password");
define("_REPASSWORD", "verify password");
define("_MARQUEE_LOGIN", "");
define("_LOGO_LOGIN", "");
define("_LOAD_WAITING", "please wait ...");


####################################### -- menu  styles --
define("_HOME", "home");
define("_DEFINE", "defines");
define("_USERS", "users");
define("_PRODUCTS", "products");
define("_BUY_SELL", "buy and sale");

define("_USER_DELETED", "user deleted successful");
define("_PRD_DELETED", "product deleted successful");
define("_SEARCH", "search");
define("_VALED", "parent");

####################################### -- bootstrp  styles --
define("_COL_12", "full page"); //fullpage
define("_COL_6", "half page");//half page
define("_COL_4", "1/3 page");//1/3 page
define("_COL_3", "1/4 page");//1/4 page
define("_COL_2", "1/6 page");//1/6 page

define("_FORM_CONTROL", "form control");
define("_SAVE_BTN", "save button");




####################################### -- form elements --
define("_BIRTH", " birthday");
define("_NAME_USER", "name of user");
define("_NAME", "name");
define("_NAME_TODO", "work name");
define("_LNAME", "last name");
define("_WORK_TELL", "work tell");
define("_WORK_ADDRESS", "work address");
define("_ADVANCED_SETTING", "advanced setting");
define("_SAVE", "  save  " . "<i class='fa fa-save'></i>");
define("_SAVE2", "  save  ");
define("_PRIVACY", "privacy");
define("_PUBLIC", "public");
define("_PRIVATE", "private");
define("_URL", "url");
define("_TAX", "tax");
define("_COMPANY", "company");
define("_PIC", "pic");
define("_DATE", "date");
define("_NUM", "count");
define("_DATE_PH", "year/ mounth / day");
define("_CODE", "code");
define("_KALA", " product");
define("_DES", " description ");
define("_MESSAGE", " message ");
define("_PERMISION_DENIED", "access denied");
define("_START", "start");
define("_END", "end");
define("_LOGOUT", "logout");
define("_SEED", "readed");
define("_PARENT", "parent");
define("_FROM", " from ");
define("_TO", " to ");
define("_COMMISSION", "commision");
define("_PRICE_PRD_COMMISSION", "products and commisions");
define("_CONVERT_TO", " convert to ");
define("_DETAILS", "details");
define("_CURRENT_STATE", "current status");
define("_LAST", "last");
define("_PRO_FORMA", "proforma number");
define("_DATE_END", "expire date");
define("_SUC_OP", "operation successful");
define("_NO_SUC_OP", "operation failed");
define("_INPUT", " input ");
define("_CLIENT", "client");
define("_CLIENTS", "clients");
define("_LOADING", "loading");
define("_LAST_FOLOWS", "last flows");
define("_VIEW", " view ");
define("_FOLOWS", " flows ");
define("_CURRENT", " current ");
define("_ENTIRE_TIME", "remain time");
define("_DAY", "day");
define("_MOUNTH", "mounth");
define("_WEEK", "week");
define("_ORDER_BY", "order by");
define("_NO_SELECTED", "nothing selected");
define("_VIP", "vip");
define("_EDITOR", "editor");
define("_SELECT_DATE", "date picker");
define("_SELECT_BOOL", "boolean select");
define("_SELECT_MANUAL_JSON‌", "json selector");
define("_SELECT_DB", "انتخابگر با استفاده از بانک اطلاعاتی");
define("_SELECT_FIELD_DATA", "database selector");
define("_SELECT_FIELD_DATA_GROUP", "database group selector");
define("_SUBMIT", "submit");


####################################### -- ACCOUNTING -- mali  --
define("_MY_EMPLOY", "my experts");
define("_TOTAL_PLUS", "totlal price");
define("_TMP_USERS", "temprory user");
define("_PROFILE_SETTING", "profile setting");
define("_OTHER_PAY", "other pays");
define("_PER_PAGE", "per page");
define("_CLIENT_LIST", "client list");
define("_NOT_FOUND", "not found");
define("_ALERT_NOT_FOUND", "alert not found !");
define("_VIEW_PAGE", "view page");
define("_REQ_FINISH", "request finished");
define("_FILTERED_FROM", "filtered from");
define("_MY_CLIENT", "my clients");
define("_BEDEHKAR", "debtor");
define("_BESTANKAR", "creditor");
define("_BED", "deb");
define("_BES", "cre");
define("_CHART", "chart");
define("_REFRENCE", "refrence");
define("_JOB", "job");
define("_COPY", "copy");
define("_COLUMNS", "columns");
define("_REFRESH", "refresh");
define("_IS_REQUIRED", "is required");
define("_RECIVERS", "recivers");
define("_ACCEPT", "accept");
define("_MANAGE_USER_GROUP_EMPLOY", "manage groups of admin user ");
define("_MANAGE_PRD_GROUP", "manage groups of products");
define("_MANAGE_EEMPLOYS", "manage employers");
define("_EDIT_FULLL", "edit full");
define("_EDIT_ALL_SETTING", "edit full setting");
define("_MANAGE_GROUPS", "manage groups");
define("_MANAGE_CLIENTS", "manage clients");
define("_MANAGE_ALL_CLIENTS", "manage clients");
define("_MANAGE_FORM_TREES", "manage form categories");
define("_MANAGE_FIELD_DATA", "manage field data");
define("_MANAGE_AUTO_AUTO_REFER_USER", "manage auto refters for users");
define("_EXITED_FORM_KARTABLE", "exited");
define("_MENU", "menu");
define("_DASHBOARD", "dashboard");
define("_REQUIRED", "required");
define("_MIN", "minimum");
define("_MAX", "maximum");
define("_OUT_OF_RENGE", "out of range");
define("_SHOW_ALL", "show all");
define("_DATE_CREATE", "created at");
define("_EXCEL_CSV", "EXCEL/CSV");
define("_FILL_PROFILE", "fill profile");
define("_FILL_PROFILE_SUC", "fill profile successful.");
define("_FILL_PROFILE_ERROR", "error in update profile.");
define("_UPLOAD_MANAGER", "uploads");
define("_ADD_NEW_ITEM", "add new item");
define("_CARTON", "package");
define("_GHABZ", "bill");
define("_MAKE", "make");
define("_MODIFY", "modify");
define("_ACCESS_DENIED", "access denied");
define("_SABT", "save");
define("_BEDEHKARAN", "debtor");
define("_EXPORT", "export");
define("_LOT", "lot");
define("_TRANSFER", "transfer");
define("_SOURCE", "source");
define("_DEST", "destition");
define("_DELIVERY", "delivery");
define("_CHECKOU", "cheque");
define("_MAILI_DISABLED", "not received");
define("_MALI_ENABLED", "received");
define("_SERIAL", "serial");

define("_IN", " in ");
define("_OUT", " out ");
define("_PRD", "product");
define("_MAIN", " main ");
define("_PRICE", " price ");
define("_STATE", "status");
define("_FILE", "file");
define("_OTH", " other ");
define("_FREE", " free ");
define("_DEFUALT", "default");
define("_RECIVER", "reciver");
define("_REAL", "real");
define("_OP", "operations");
define("_ALT", " lateral ");

####################################### -- crm --
define("_RIVAL", "rival");
define("_RIVALS", "rivals");
define("_MANAGE_RIVALS", "manage rivals");
define("_BRAND", "brand");
define("_PRD_COUNTRY", "producer country");
define("_PRD_RELATED", "related product");
define("_PRD_CONTACT", "product contact details");
define("_SUC_OP_CONVERT_USER", "user convert successful");


####################################### -- stock --
define("_PARENT_STOCK", "parent stock");
define("_SUPPLY", " inventory ");
define("_STOCK_HANDING", " stock-check ");
define("_LACK", " lack ");
define("_STOCK_CHECK", "stock-check");
define("_STOCK", " stock ");
define("_MANAGE_STOCK", "amnage stocks ");
define("_MANAGE_MOJOODI", "inventory of stocks");
define("_MANAGE_STOCK_IN", "manage input");
define("_MANAGE_STOCK_OUT", "manage output");
define("_RENDER_STOCK_RECEPI", "stock recepie");


####################################### -- ACCOUNTING  --
define("_NAME_BANK", "bank name");
define("_BRANCH_BANK", "branch bank");
define("_ACCOUNT_NUMBER_BANK", "credit no");
define("_RECIVER_BANK", "reciver bank");
define("_FULL_INVOICE", "invoice ");


####################################### -- ENGLISH BASE --
define("_PRICE_TOTAL_EN", "TOTAL PRICE");
define("_TAKHFIF_EN", "DISCOUNT");
define("_VAHED_EN", " UNIT ");
define("_PRICE_EN", "PRICE");
define("_NUM_EN", "QTY");
define("_DES_EN", " DESCRIPTION OF ");
define("_KALA_EN", "ITEMS ");
define("_CODE_EN", "CODE");
define("_R_EN", " IRR");
define("_CLIENT_PRICE_EN", "CONSUMER");



####################################### -- USERS --
define("_FULL_NAME", "full name");
define("_MELI_ID", "national number");
define("_REAGENT", "reagent");
define("_ACTION", "actions");
define("_AGENT", "agent");
define("_POSTAL_CODE", "postal code");
define("_TELL", "tell");
define("_TYPE_USER", "type");
define("_HAGHIGHI", "natural");
define("_HOGHOOGHI", "legal entity");
define("_USER_GROUP", "user group");
define("_CODE_EGHTESADI", "company national number");
define("_MOBILE", "mobile");
define("_EMAIL", "email");
define("_ADDRESS", "address");
define("_PERSONAL_SETTING", "personal setting");
define("_LOGIN_SETTING", "login setting");
define("_DES_SETTING", "Pony method");
define("_COMMERICAL_ID", "comerical number");
define("_ID_CLIENT", "client id");
define("_MORE_INFO", "more info");
define("_WEB", "website address");
define("_PERFIX_CODE", "perfix user id");
define("_EXTRA1", "name");  // extra field form tabl_user extra 1
define("_EXTRA2", "contact person");  // extra field form tabl_user extra 2
define("_EXTRA3", "address");  // extra field form tabl_user extra 3
define("_EXTRA4", "city,state,zip");  // extra field form tabl_user extra 4
define("_EXTRA5", "Country");  // extra field form tabl_user extra 5
define("_STATUS_CLIENT", "client status");
define("_EXTRA1_TMP_USER", "extra detail 1"); // extra for temp_client extra 1
define("_EXTRA2_TMP_USER", "extra detail 2"); // extra for temp_client extra 2
define("_VIEW_TRACKS", "view tracks");
define("_TYPE_TRACK", "type track here ...");
define("_TMP_PEYMENT", "Pony method");
define("_TMP_TYPE", "type");
define("_PEIGIRI", "track");
define("_REPLAY", "replay");
define("_TYPE_REPLAY", "type reply here ...");
define("_CHANGE_PASSWORD", "change password");
define("_CURRENT_PASSWORD", "current password");
define("_NEW_PASSWORD", "new password");
define("_RETYPE_NEW_PASSWORD", "retype new password");
define("_ERROR_RETYPE_PASSWORD", "error: password and retype password not same.");

define("_NEW", "new");
define("_DUPLICATE", "duplicate");
define("_CHANGED_SUC", "changed successful");
define("_FATHER", "father");
define("_SHOPING_STORE", "store");
define("_ACCEPTED_SUC", "accepted successful");
define("_SALARY", "salary");
define("_HOUR_WORK", "hourly work");
define("_GROUP", "group");
define("_PERCENT", "%");
define("_EXTRA1_PROMOTER", "extra1"); // extra field for promotor extra 1
define("_EXTRA2_PROMOTER", "extra2"); // extra field for promotor  extra 2
define("_EXTRA3_PROMOTER", "extra3"); // extra field for promotor  extra 3





####################################### -- fACTOR = invoice --
define("_MANAGE_INVOICE","manage invoice");
define("_MANAGE_FACTOR_LEVELS","manage factor levels and groups");
define("_PRICE_FACTOR", "price of invoice");
define("_ADD_FACTOR", "add new invoice");
define("_PERMISION", "permision");
define("_VIEW_FACTOR_THIS_MOUNTH", "view this mounth invoices");
define("_VIEW_FACTOR_LEVEL1", "view accepted invoices");
define("_VIEW_FACTOR_WAIT_LEVEL1", "view on processing invoices");
define("_VIEW_FACTOR", "view invoice");+
define("_FACTOR", "invoice");
define("_FACTOR_NUM", "invoice id");
define("_FACTOR_CLIENT", "client");
define("_FACTORـTYPE", "invoice type");
define("_FACTORـDATE", "invoice date");
define("_FACTOR_DES", "invoice more information");
define("_EXPIRE_FACTOR", "invoice expire date ");
define("_FACTOR_ROW_PLUS_", "expire date"); //for add some detail of prd in factor line1 of header
define("_FACTOR_ROW_PLUS_2", "EXPIRY"); //for add some detail of prd in factor line2 of header
define("_FACTOR_SELL", "sale invoice");
define("_FACTOR_BUY", "Purchase invoice");
define("_NAME_CLIENT", "Purchaser name");
define("_FACTOR_DELETED", "invoice deleted successful");
define("_VIEW_ALL_FACTOR_SELL", "view sale invoices");
define("_VIEW_ALL_FACTOR_SELL_ALLUSER", "view all sale invoices");
define("_VIEW_ALL_FACTOR_SELL_REQ_REG", "final registration requests");
define("_ADDED", "added successful.");
define("_NOT_ADDED", "added failed");
define("_PRICE_MAIN", "main price");
define("_PRICE_TOTAL", "total price");
define("_SUB_TOTAL_EN", "SUBTOTAL AMOUNT ");
define("_NUM_TOTAL", "total");
define("_EZAFAT", "additions");
define("_KOSOORAT", "deductions");
define("_MABLAGH", "price");
define("_PARDAKHT_SETTING", "pay type");
define("_TAKHFIF", "off price");
define("_TAKHFIF_KHATI", "line off price");
define("_PRICE_TOTAL_STRING", "total price in letters");
define("_PRD_TAKHFIF", "main price after off price");
define("_REJECT", "reject");
define("_TYPE", "type");
define("_MIN_LIMIT_SELL", "minimum sale limit");
define("_REMIND", " remain ");
define("_SELL", " sale ");
define("_FREE_OF_CHARGE_EN", " free of charge ");
define("_CLIENT_PRICE", "client price");
define("_LAST_PRICE", "last price");
define("_NAME_MAKER", "invoice maker");
define("_DES_INVOICE_PH", "invoice description");




define("_VAHED", "unit"); //unit
define("_VAHED_ASLI", "main unit"); // main unit
define("_GROUP_PRD", "product group");
define("_NUM_PRD", "number of product");
define("_COMPANY_MAKER", "made in ");
define("_ORDER_POINT", "order point");
define("_FANI_NUMBER", "serial");
define("_BARCODE", "barcode");
define("_COUNTRY_MAKER", "maker country");
define("_PRICE_SETTING", "prices");
define("_OUT_STACK_ALERT", "alert for shortage of inventory");
define("_LAST_MOUNTH", "last mounth");
define("_GETED", "cashed");
define("_GET", "cash");
define("_GET_MONEY", "cash price");
define("_PAY_MONEY", "payed money");
define("_PAYOFF", "checkout");
define("_OFF_PRICE", "off price");


####################################### -- REPORT MAKER --
define("_REPORT", "report");
define("_REPORTS", "reports");
define("_TYPE_YOUR_REPORT", "type of reports");
define("_LIST_REPORT", "list of reports");
define("_ADD_REPORT", "add report");
define("_LIST_REPORT_SYSTEM", "list of system reports ");


####################################### -- DASHBOARD --
define("_NEW_MESSAGE", "new message");
define("_VIEW_DETAILS", "view details");
define("_VIEW_BELGHOVE", "view permanent client");
define("_BELGHOVE", "permanent clients");
define("_VIEW_BELFEL", "vew temprory client");
define("_BELFEL", "مشتریان بالفعل");
define("_REJECT_FORM", "reject form");
define("_SALARY_THIS_MOUNTH", "this month salary");


####################################### -- automation , form maker --
define("_AUTOM", "automation");
define("_ENTER_DATA", "enter data");
define("_KARTABL", "kartable");
define("_ADD_IMPOERT", "inbox");
define("_ADD_EXPORT", "outbox");
define("_FORM", "form");
define("_letter", "letter");
define("_NUMBER", "number");
define("_FIELD", "field");
define("_SECEND", "secent");
define("_CSS_CLASS", "CSS class");
define("_CSS_CLASS_PARENT", "parent CSS class");
define("_CSS_STYLE", "CSS style");
define("_SHOW_LIST", "show list");
define("_MODE", "mode");
define("_TREE", "tree");
define("_REFER", "refer");
define("_SHARE", "share");
define("_FIELD_DATA", "field data");
define("_VALUE", "value");
define("_SUBJECT_REFER", "refer subject");
define("_AUTO_REJECTS", "rejects");
define("_EXIT_FROM_KARTABLE", "exit from kartable");
define("_AUTO_REJECT", "reject");
define("_REFER_TO", "send to");
define("_UNREAD", "unreaded");
define("_ACCEPTED", "accepted");
define("_REJECTED", "rejected");
define("_NUMBER_INPUT", "number input");
define("_FORM_LISTS", "form list");
define("_FILTER_VALUE", "values filter");
define("_DELETE_CREATE_TABLES", "reset table");
define("_SUC_AUTO_ADD", "input data successful ");
define("_AUTO_NEW_OP", "please select next step");
define("_RETURN_TO_ADD_FORM", "return to input data page");
define("_AUTO_EDIT_SAME", "edit last entery");
define("_AUTO_NEW_ADD", "new input data");
define("_ADD_FORM_SEARCHABLE", "search form");
define("_َAUTO_LAST_MINE", "my kartable");
define("_AUTO_ADD_FORM", " save ");
define("_ACCEPTER", "corroborant");
define("_DATE_ACCEPT", " accept date ");
define("_REJECTER", " rejector ");
define("_DATE_REJECT", " reject date ");
define("_DES_REJECT", " reject details ");
define("_HISTORY_FORM", "history");


####################################### -- update --define("_UPDATE", "بروز رسانی");
define("_UPDATED", "updated successful");
define("_VERSION", "version");
define("_FOUND_NEW_VERSION", "new version founded");
define("_GET_NEW_UPDATE", "get new update");
define("_LAST_VERSION_DOWNLOADED", "last version downloaded");
define("_LAST_VERSION_IS_THERE", "last version is available now");
define("_MAKE_FOLDER", "make folder");
define("_RUNED", "run");
define("_ARE_YOU_READY_FOR_UPDATE", "are you sure for update (please get backup befor update)?");
define("_UPDATED_DONE_TO", "updated successful to version");
define("_UPDATED_NOT_FOUND", "update not found");
define("_SERVER_NOT_FOUND", "server not found");


####################################### -- media manager --
define("_MANAGE_MEDIA", "manage media");
define("_ADD_MEDIA", "add media");
define("_ADD_MEDIA_CLICK_HERE", "click here for add media");
define("_FILE_UPLOAD_SUCESSFUL", "uploaded successful");
define("_ERROR_IN_UPLOAD", "error in uploading files : ");
define("_VIEW_MEDIA", "view media detail : ");
define("_MANAGE_GROUP_MEDIA", "manage groups of media");
define("_INFO_MEDIA", "media information");
 

