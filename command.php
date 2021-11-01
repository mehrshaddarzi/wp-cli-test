<?php

if(class_exists('\WP_CLI')) {
	\WP_CLI::add_command('application', App_Command::class);
}
