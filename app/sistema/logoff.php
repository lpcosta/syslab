<?php
  $_SESSION = array(); 
  print "<script>
        document.location.href='./';
        </script>
        ";
session_destroy();