<?php
class Config_db{
    const DB_TABLE_PREFIX = '';
    //mysql params for single mysql server or master server in master slave mode
    const DB_HOST = 'mymariadb';
    const DB_USER = 'helPHP';
    const DB_BASE = 'helPHP';
    const DB_PASS = '';

    const MASTER_SLAVE_MODE = false;
    const DB_SLAVE_HOST = 'maria-slave';
    const DB_SLAVE_USER = 'helPHP';
    const DB_SLAVE_BASE = 'helPHP';
    const DB_SLAVE_PASS = '';

    const DB_CENTRAL = false;
    const DB_CENTRAL_HOST = 'maria-central';
    const DB_CENTRAL_USER = 'helPHP';
    const DB_CENTRAL_BASE = 'helPHP';
    const DB_CENTRAL_PASS = '';  
    const DB_CENTRAL_TABLES = ['group_data','group_users','users_address','users_connexions','users_data'];  

    const DB_JOBS = false;
    const DB_JOBS_HOST = 'maria-master';
    const DB_JOBS_USER = 'helPHP';
    const DB_JOBS_BASE = 'helPHP_jobs';
    const DB_JOBS_PASS = '';

}
