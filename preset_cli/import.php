<?

$_SERVER["DOCUMENT_ROOT"] = dirname( dirname( __FILE__) );
define( "NO_KEEP_STATISTIC", true );
define( "NO_AGENT_STATISTIC", true );
define( "NOT_CHECK_PERMISSIONS", true );

require( $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php" );
CModule::IncludeModule('adv_preset');
$argv = array(null, $_GET['act'], $_GET['rev']);

if (count($argv) >= 1)
{
    array_shift($argv);

    $operation = reset($argv);

    switch ($operation)
    {
        case 'update':
            $revisionNum = intval($argv[1]);
            if (!$revisionNum)
                $revisionNum = 0;
            $Import = new CImport();
            $ImportResult = $Import->ImportRevision($revisionNum);

            if ($ImportResult)
            {
                $CurrentRevision = $Import->GetCurrentRevision();
                echo(str_replace('#REVNUM#', $revisionNum, $MESS['UPDATE_REVISION']).PHP_EOL);
            }
            else
                die($Import->GetError());
            break;
        case 'revert':
            $revisionNum = intval($argv[1]);
            if ($revisionNum || $argv[1] === '0')
            {
                $Import = new CImport();
                $ImportResult = $Import->RevertRevision($revisionNum);

                if ($ImportResult)
                {
                    $CurrentRevision = $Import->GetCurrentRevision();
                    echo(str_replace('#REVNUM#', $revisionNum, $MESS['REVERT_REVISION']).PHP_EOL);
                }
                else
                    die($Import->GetError());
            }
            else
                die($MESS['EMTY_REV_NUMBER'].PHP_EOL);
            break;
        default:
            die($MESS['OPCODE_INVALID'].PHP_EOL);
    }
}
else
    die($MESS['EMPTY_OPPARAM'].PHP_EOL);