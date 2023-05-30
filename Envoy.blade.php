@servers(['web' => 'root@boxify.be', 'localhost' => '127.0.0.1'])

@setup
#<?php # please keep this line (for syntax highlighting)
if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('GMT');
}
// Parameters
$composer = $composer ?:false;
$seed = $seed ?: false;

// @example "envoy run deploy --seed=*"
if ($seed == '*') {
    // @TODO - Get all Seed classes
}

// @example "envoy run deploy --composer"
if ($composer === '') {
    $composer = 'update';
}

$now = new DateTime();
$environment = isset($env) ? $env : "testing";
if (isset($slack)) {
    Laravel\Envoy\Slack::make('https://hooks.slack.com/services/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', '#boxify', "$slack ran on [$environment]")->task($task)->send();
}
@endsetup



@task('deploy', ['on' => 'web'])
cd /home/boxify/web/demo
git pull
git submodule update
git status
chown -R www-data /home/boxify/web/demo/public/files

@if ($composer)
    echo "> Composer [{{ $composer }}]";
    composer {{ $composer }}
@endif

@if ($seed)
    echo "> Seed [{{ $seed }}]";
    php artisan db:seed --class={{ $seed }}
@endif
@endtask



@task('deploy_prod', ['on' => 'web'])
cd /home/boxify/web/www
git pull
git submodule update
git status
chown -R www-data /home/boxify/web/www/public/files
@endtask



@task('migrate', ['on' => 'web'])
cd /home/boxify/web/demo
php artisan migrate
@endtask



@task('composer_update', ['on' => 'web'])
cd /home/boxify/web/demo
composer update
@endtask



@task('switch-local', ['on' => 'localhost'])
cp -f .env.local .env
@endtask



@task('switch-demo', ['on' => 'localhost'])
cp -f .env.demo .env
@endtask



@task('sync-db-demo', ['on' => 'localhost'])
# Database credentials
user="boxify"
password="ch3rr630826!"
host="boxify.be"
db_name="boxify_demo"

# Other options
backup_path="_backup"
date=$(date +"%Y_%m_%d")
# Set default file permissions
umask 177

# Dump database into SQL file
/Applications/MAMP/Library/bin/mysqldump --user=$user --password=$password --host=$host $db_name > $backup_path/dump_$date.sql

/Applications/MAMP/Library/bin/mysql --user="root" --password="root" --host="localhost" boxify_demo < $backup_path/dump_$date.sql
@endtask

@task('sync-db-prod', ['on' => 'localhost'])
# Database credentials
user="boxify"
password="ch3rr630826!"
host="boxify.be"
db_name="boxify_v2"

# Other options
backup_path="_backup"
date=$(date +"%Y_%m_%d")
# Set default file permissions
umask 177

# Dump database into SQL file
/Applications/MAMP/Library/bin/mysqldump --user=$user --password=$password --host=$host $db_name > $backup_path/dump_$date.sql

/Applications/MAMP/Library/bin/mysql --user="root" --password="root" --host="localhost" boxify_demo < $backup_path/dump_$date.sql
@endtask

@task('sync-db-prod-to-demo', ['on' => 'localhost'])
# Database credentials
user="boxify"
password="ch3rr630826!"
host="boxify.be"
db_name="boxify_v2"

# Other options
backup_path="_backup"
date=$(date +"%Y_%m_%d")
# Set default file permissions
umask 177

# Dump database into SQL file
/Applications/MAMP/Library/bin/mysqldump --user=$user --password=$password --host=$host $db_name > $backup_path/dump_$date.sql
/Applications/MAMP/Library/bin/mysqldump --user=$user --password=$password --host=$host boxify_demo > $backup_path/dump_demo_$date.sql

/Applications/MAMP/Library/bin/mysql --user=$user --password=$password --host=$host boxify_demo < $backup_path/dump_$date.sql
@endtask



@task('sync-labels-demo', ['on' => 'localhost'])
# Database credentials
user="boxify"
password="ch3rr630826!"
host="boxify.be"
db_name="boxify_demo"

# Other options
backup_path="_backup"
date=$(date +"%Y_%m_%d")
# Set default file permissions
umask 177

# Dump database into SQL file
/Applications/MAMP/Library/bin/mysqldump --user=$user --password=$password --host=$host $db_name labels > $backup_path/dump_labels_$date.sql

/Applications/MAMP/Library/bin/mysql --user="root" --password="root" --host="localhost" boxify_demo labels < $backup_path/dump_labels_$date.sql
@endtask



@task('sync', ['on' => 'localhost'])
rsync -azP root@boxify.be:/home/boxify/web/www/public/files/* ./public/files
@endtask

@task('sync-demo', ['on' => 'localhost'])
rsync -azP root@boxify.be:/home/boxify/web/demo/public/files/* ./public/files
@endtask

@task('composer', ['on' => 'web'])
cd /home/boxify/web/demo
composer update
@endtask



@task('seed', ['on' => 'localhost'])
php artisan db:seed --class=TestUserSeeder
echo "DB User Test seeded and refreshed"
@endtask



@task('last-seed', ['on' => 'localhost'])
php artisan db:seed --class=ArxminPermissionsSeeder
echo "Last seed ok"
@endtask



@task('composer-dump', ['on' => 'web'])
cd /home/boxify/web/www
composer dump-autoload
@endtask



@task('sync-labels', ['on' => 'localhost'])
php artisan labelmanager:sync
@endtask
