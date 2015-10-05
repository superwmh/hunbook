# Grand Child #

```
<?php
/*
    Father
     +-- Child
          +-- Grand-child
*/
function log2($msg) {
    echo date("Y-m-d H:i:s ") . getmypid() .' '. $msg . "\n";
}
log2("This is the script start.");

$cpid = pcntl_fork();
log2("Forking...");
if ($cpid == -1) {
    die('error: unable to fork.');

} else if ($cpid) {
    log2($cpid . ':father process...');

} else {
    sleep(1);
    log2($cpid . ':child process...');

    $gcpid = pcntl_fork();
    log2("Forking again...");
    if ($gcpid == -1) {
        die('error: unable to fork.');
    } else if ($gcpid) {
        log2($gcpid . ':child process...');
    } else {
        log2($gcpid . ':grand-child process...');
    }
}
log2("This is the script end.");
```

# Two Children #

```
<?php
/*
    Father
     +-- Child
     +-- Child
*/
function log2($msg) {
    echo date("Y-m-d H:i:s ") . getmypid() .' '. $msg . "\n";
}
log2("This is the script start.");

$cpid2 = 0;
$cpid1 = pcntl_fork();
if ($cpid1) $cpid2 = pcntl_fork();
log2("Forking...");

if ($cpid1 == -1) {
    die('error: unable to fork.');

} else if ($cpid1 && $cpid2) {
    log2($cpid1 .' '. $cpid2 . ':father process...');

} else {
    log2($cpid1 .' '. $cpid2 . ':child process...');

}
log2("This is the script end.");
```

# Monitoring Child #

```
<?php
/*
   Monitoring Child Process
*/
function log2($msg) {
    echo date("Y-m-d H:i:s ") . getmypid() .' '. $msg . "\n";
}
function _sleep($msec) {
    $start = time();
    while (1) {
        if (time() - $start > $msec) break;
    }
}
log2("This is the script start.");

$cpid = pcntl_fork();
log2("Forking...");

if ($cpid == -1) {
    die('error: unable to fork.');

} else if ($cpid) {
    pcntl_waitpid($cpid, $status, WUNTRACED); //Protect against Zombie children
    log2("Child status: ".$status);
    if (pcntl_wifexited($status)) {
        log2("Child exited normally");
    } else if (pcntl_wifstopped($status)) {
        log2("Signal: ". pcntl_wstopsig($status). " caused this child to stop.");
    } else if (pcntl_wifsignaled($status)) {
        log2("Signal: ". pcntl_wtermsig($status)." caused this child to exit with return code: ". pcntl_wexitstatus($status));
    }

} else {
    set_time_limit(1);                      // timeout status is 65280
    log2($cpid . ':child process...');
    _sleep(2000);
    exit(2);
}
log2("This is the script end.");

```

# Multiple Children #

```
<?php
/*
   Multiple Child Process
*/
function log2($msg) {
    echo date("Y-m-d H:i:s ") . getmypid() .' '. $msg . "\n";
}
log2("This is the script start.");

$cnt = 0;
$max = 3;

while (1) {
    $cnt++;
    $cpid = pcntl_fork();
    log2("Forking...");

    if ($cpid == -1) {
        die('error: unable to fork.');

    } else if ($cpid) {
        if ($cnt >= $max) {
            pcntl_wait($status);
            log2('Got child status: '. $status);
            $cnt--;
        }
    } else {
        $s = mt_rand(9, 19);
        log2('Child process...('. getmypid() .', '. $s .' sec)');
        sleep($s);
        log2('Child finish ('. getmypid() .', '. $s .' sec)');
        exit;
    }
}
```