<?php

$hash = '$2y$10$u1NnX2NDSSSXqoQZnIcEqe8eX2HFqRSbuuSSMzdON3NofM8JrIo5a';

var_dump(password_verify('admin123', $hash));
