<?php
// Next and previous month
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // This month
    $ym = date('Y-m');
}

// Check format
$ts = strtotime($ym . '-01');
if ($ts === false) {
    $ym = date('Y-m');
    $ts = strtotime($ym . '-01');
}

// Today date
$today = date('Y-m-j', time());

// Date used in H3
$h3_title = date('Y / m', $ts);

// Create previous and next month link     
$prev = date('Y-m', mktime(0, 0, 0, date('m', $ts)-1, 1, date('Y', $ts)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $ts)+1, 1, date('Y', $ts)));


// Number of days in the month
$day_count = date('t', $ts);
 
// Positions of days of week in calendar
$str = date('w', mktime(0, 0, 0, date('m', $ts), 0, date('Y', $ts)));



// Create Calendar
$weeks = array();
$week = '';

// Add empty cell
$week .= str_repeat('<td></td>', $str);

for ( $day = 1; $day <= $day_count; $day++, $str++) {
     
    $date = $ym . '-' . $day;
     
    if ($today == $date) {
        $week .= '<td class="today">' . $day;
    } else {
        $week .= '<td>' . $day;
    }
    $week .= '</td>';
     
    // End of the week or end of the month
    if ($str % 7 == 6 || $day == $day_count) {

        if ($day == $day_count) {
            // Add empty cell
            $week .= str_repeat('<td></td>', 6 - ($str % 7));
        }

        $weeks[] = '<tr>' . $week . '</tr>';

        // Prepare for new week
        $week = '';
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Kalendarz</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <style>
        .container {
            margin-top: 80px;
        }
        h3 {
            margin-bottom: 30px;
        }
        th {
            height: 30px;
            text-align: center;
        }
        td {
            height: 100px;
			font-size: 45px;
			text-align: center;
        }
        .today {
            background: orange;
        }
        th:nth-of-type(7), td:nth-of-type(7) {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $h3_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
        <table class="table table-bordered">
            <tr>
                <th>Pn</th>
                <th>Wt</th>
                <th>Śr</th>
                <th>Czw</th>
                <th>Pt</th>
                <th>So</th>
                <th>Nie</th>
            </tr>
            <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
            ?>
        </table>
    </div>
</body>
</html>