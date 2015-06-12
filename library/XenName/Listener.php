<?php
class XenName_Listener {
	public static function load_class_controller($class, array &$extend) {
		$extend[] = 'XenName_ControllerPublic_Register';
	}
}