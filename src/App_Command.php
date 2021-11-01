<?php

/**
 * My WordPress Site WP-CLI Command
 */
class App_Command extends \WP_CLI_Command
{

	/**
	 * Calculate User Salary
	 *
	 * ## OPTIONS
	 *
	 * <number1>
	 * : First Number
	 *
	 * <number2>
	 * : Twice Number
	 *
	 * [<number3>]
	 * : Third Number
	 *
	 * [--tax=<tax>]
	 * : Tax.
	 *
	 * [--force]
	 * : Force Calculate Tax.
	 *
	 * ## EXAMPLES
	 *
	 *      # Sum Two Number
	 *      $ wp sum 3 5
	 *      Success: 8.
	 *
	 * @when before_wp_load
	 */
	public function sum($args, $assoc_args)
	{
		if (!is_numeric($args[0]) || !is_numeric($args[1])) {
			\WP_CLI::error("Please Fill Only Numeric", $exit = true);
		}

		$Salary = $args[0] + $args[1];
		if (isset($args[2]) and is_numeric($args[2])) {
			$Salary = $Salary + $args[2];
		}

		$tax = \WP_CLI\Utils\get_flag_value($assoc_args, 'tax', 0);
		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force', false);
		if ($tax == 0 and $force === true) {
			$tax = 10;
		}
		$Salary = $Salary - $tax;


		\WP_CLI::success("Your Salary is: " . $Salary);
	}

	/**
	 * Get Number Post From Post-Type.
	 *
	 * ## OPTIONS
	 *
	 * [--type=<type>]
	 * : Post Type Slug
	 * ---
	 * default: post
	 * options:
	 *   - post
	 *   - page
	 *   - product
	 * ---
	 *
	 * @when after_wp_load
	 */
	public function total($args, $assoc_args)
	{
		$type = \WP_CLI\Utils\get_flag_value($assoc_args, 'type', 'post');
		$number = $this->getPostCount($type);
		\WP_CLI::success("Number post in " . $type . " is " . number_format($number->publish) . "");
	}

	private function getPostCount($type){
		return wp_count_posts($type);
	}
}
