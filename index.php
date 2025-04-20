<?php

/**
 * Redirect to the public directory where Laravel is properly setup
 *
 * This fixes an issue where the server is executing the root directory index.php
 * instead of the one in the public directory.
 */

header('Location: /public/');
exit; 