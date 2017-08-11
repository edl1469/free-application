<div class="container"><div id="results"><?php

        foreach ($results as $row) {
            echo $row['sn'].','.$row['givenName'];
            echo '<br>';

        }



        ?></div></div>