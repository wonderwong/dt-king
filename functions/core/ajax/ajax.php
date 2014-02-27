<?php
/*   $realpath = realpath(TMP_DIR);
   $realpath = preg_replace('/^.*(wp-content\/.*)$/', '\\1/', $realpath);

   // Check if cache is writable
   if ( !file_exists( TMP_DIR ) )
   {
      @mkdir( TMP_DIR );
      @chmod( TMP_DIR, 0777 );
   }
   
   if ( !file_exists( TMP_DIR ) )
   {
      echo " FOLDER $realpath COULD NOT BE CREATED. PLEASE CREATE IT MANUALLY WITH USER RIGHTS 777 (read/write access enabled) ";
   }
*/