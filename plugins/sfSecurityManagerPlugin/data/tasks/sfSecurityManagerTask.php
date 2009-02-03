<?php

pake_desc('List the current security');
pake_task('security-list', 'project_exists');

pake_desc('Switch the is_secure flag');
pake_task('security-is-secure', 'project_exists');

pake_desc('Add credential');
pake_task('security-add-credential', 'project_exists');

pake_desc('Delete credential');
pake_task('security-del-credential', 'project_exists');

function run_security_list($task, $args) {
	$space = 0;
	foreach (glob(sfConfig::get('sf_app_dir').'/*/config/security.yml') as $policy_file) {
		ereg("^".sfConfig::get('sf_app_dir')."/([^/]+)/", $policy_file, $matches);
		$app = $matches[1];
		echo pakeColor::colorize("$app : \n", 'COMMENT');
		$space++;
		$policy = sfYaml::load($policy_file);
		if (isset($policy['default'])) {
			echo parseSecurity($policy['default'], $space);
		}
		else {
			echo pakeColor::colorize($space."No default policy\n", 'ERROR');
		}
		
		foreach (glob(sfConfig::get('sf_app_dir')."/$app/modules/*/config/security.yml") as $security_file) {
			ereg("^".sfConfig::get('sf_app_dir')."/$app/modules/([^/]+)/", $security_file, $matches);
			$module = $matches[1];
			echo str_repeat('  ', $space).pakeColor::colorize("$module : \n", 'COMMENT');
			$security = sfYaml::load($security_file);
			$space++;
			if (is_array($security)) {
				foreach($security as $action => $rules) {
					echo str_repeat('  ', $space).pakeColor::colorize("$action".($action=='all'?" (default)":"")." : \n", 'COMMENT');
					$space++;
					echo parseSecurity($rules, $space);
					$space--;
				}
			}
			else {
				echo str_repeat('  ', $space).pakeColor::colorize("    No configuration\n", 'ERROR');
			}
			$space--;
		}
		$space--;
	}
}

function parseSecurity ($security, $space = 0) {
	$result = str_repeat('  ', $space).'is_secure   : ';
	if (!empty($security['is_secure'])) {
		$result .= pakeColor::colorize("yes\n", 'INFO');
	}
	else {
		$result .= pakeColor::colorize("no\n", 'ERROR');
	}
	if (isset($security['credentials'])) {
		$result .=  str_repeat('  ', $space).'credentials : '.pakeColor::colorize(parseCredentials($security['credentials'])."\n", 'INFO');				
	}
	return $result;
}

function parseCredentials ($credentials, $type = 'and') {
	if (!is_array($credentials)) {
		return $credentials;
	}
	$result = array();
	foreach ($credentials as $credential) {
		if (is_array($credential)) {
			$result[] = '( '.parseCredentials($credential, 'or').' )';
		}
		else {
			$result[] = $credential;
		}
	}
	return implode(" $type ", $result);
}

function run_security_is_secure($task, $args) {
	update_configuration('is_secure', $args);
}

function run_security_add_credential($task, $args) {
	
	update_configuration('add_credential', $args);
}

function run_security_del_credential($task, $args) {
	
	update_configuration('del_credential', $args);
}

function update_configuration($type, $args) {
	
	if (sizeof($args) < 2) {
		throw new Exception('Usage : symfony security-issecure app [module] [action] credential');
	}
	
	if (sizeof($args) == 2) {
		// App update
		run_app_exists($task, $args);
		
		$app    = $args[0];
		$module = null;
		$action = 'default';
		$value  = $args[1];
	}
	else {
		// Module update
		run_module_exists($task, $args);
		
		$app    = $args[0];
		$module = $args[1];
		if (sizeof($args) == 3) {
			// Default update
			$action = 'all';
			$value  = $args[2];
		}
		else {
			// Action update
			$action = $args[2];
			$value  = $args[3];
		}
	}
	
	if (empty($module)) {
		// App update
		$yml_file = sfConfig::get('sf_app_dir').'/'.$app.'/config/security.yml';
	}
	else {
		// Module update
		$yml_file = sfConfig::get('sf_app_dir').'/'.$app.'/modules/'.$module.'/config/security.yml';
	}
	
	$config = sfYaml::load($yml_file);
	
	// Update config
	switch ($type) {
		case 'is_secure':
			if (!in_array($value, array('on', 'off'))) {
				throw new Exception('Invalid flag');
			}
			else {
				$config[$action]['is_secure'] = $value;
			}
			break;
		case 'add_credential':
			if (!empty($config[$action]['credentials']) && in_array($value, $config[$action]['credentials'])) {
				throw new Exception('Credential already set');
			}
			else {
				$config[$action]['credentials'][] = $value;
			}
			break;
		case 'del_credential':
			if (empty($config[$action]['credentials']) || !in_array($value, $config[$action]['credentials'])) {
				throw new Exception('Credential isn\'t set');
			}
			else {
				unset($config[$action]['credentials'][array_search($value, $config[$action]['credentials'])]);
			}
			break;
		default:
			throw new Exception('Invalid type of update');
	}
	
	// Save config
	file_put_contents($yml_file, sfYaml::dump($config));
	pake_echo_action('save', $yml_file);
}
