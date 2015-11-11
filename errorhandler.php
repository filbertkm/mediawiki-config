<?php

class SimpleErrorHandler {

	public static function error_handler( $errorNumber, $message, $errfile, $errline ) {
		if ( 0 === error_reporting() || !doReportLevel( $errorNumber ) ) {
			return false;
		}

		switch ( $errorNumber ) {
			case E_ERROR:
			case E_USER_ERROR:
				$errorLevel = 'Error';
				break;
			case E_WARNING:
			case E_USER_WARNING:
				$errorLevel = 'Warning';
				break;
			case E_NOTICE:
			case E_USER_NOTICE:
				$errorLevel = 'Notice';
				break;
			default:
				$errorLevel = 'Other';
		}

		if ( $errorLevel !== false ) {
			reportError( $errorLevel, $message, $errfile, $errline );
		}

		return true;
	}

	private function doReportLevel( $errorNumber ) {
		return ( error_reporting() & $errorNumber ) === $errorNumber;
	}

	private function reportError( $errorLevel, $errorNumber, $message, $errfile, $errline ) {
		$error[] = $errorLevel . ': ' . $errorNumber . ': ' . $message . ' in ' . $errfile . ' on line ' . $errline;
		$backtrace = debug_backtrace();

		foreach( $backtrace as $key => $line ) {
			$errorLine =  '#' . $key . ': ';

			if ( array_key_exists( 'file', $line ) ) {
				$errorLine .= $line['file'];
			}

			if ( array_key_exists( 'line', $line ) ) {
				$errorLine .= ' (' .  $line['line'] . '): ';
			}

			$errorLine .= $line['function'];
			$error[] = $errorLine;
		}

		if ( PHP_SAPI === 'cli' ) {
			echo implode( "\n", $error ) . "\n";
		} else {
			echo "<div style='background: #eee; padding: 1em'>" . implode ( "<br/>", $error ) . '</div>';
		}
	}

	public static function fatal_handler() {
		$last_error = error_get_last();

		if ( $last_error !== null ) {
			// @todo
		}
	}
}
