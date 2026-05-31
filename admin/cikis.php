<?php

session_start();

session_destroy();

echo "
<script>

    window.location.href =
    '/kozmetik_magazasi/admin/giris.php';

</script>
";

exit;
