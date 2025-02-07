<?php
            var_dump(password_verify("admin", "$2y$10$vmOrUKMbwZ14hTD8/dYG8OsRbs8JhSgSeJwWgoTSsM.xfETOsQVmy"));

            echo password_hash('admin', PASSWORD_BCRYPT);

