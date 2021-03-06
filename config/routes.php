<?php
include_once dirname(__FILE__) . '/libs.inc.php';
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set("display_errors","On");
Theogony\RoutesCore::draw(function($router) {
	# You can set prefix directory for this site.
	#		$router->predir = '/';
	$router->predir = '/guestbook/';

  # Sample of regular route:
  #   $router->match(array('products/:id' => 'catalog#view'));
  # Keep in mind you can assign values other than :controller and :action

  # Sample of named route:
  #		$router->match(array('products/:id/purchase' => 'catalog#purchase', ':as' => 'purchase'));

	# You can have the root of your site routed with "root"
  # just remember to delete public/index.html.
  # $router->root = 'welcome#index';
	$router->root = 'board#index';

  # This is a legacy wild controller route that's not recommended for RESTful applications.
  # Note: This route will make all actions in every controller accessible via GET requests.
  # $rouner->match(':controller(/:action(/:id))(.:format)');
	$router->match(':controller(/:action(/:id))(.:format)');
	$router->match(array('board-(:board)(/page-:page)(.:format)' => 'board#index'));
	$router->match(array('board-(:board)/message-new(.:format)' => 'message#new_'));
	$router->match(array('board-(:board)/message-(:msg)/edit(.:format)' => 'message#edit'));
	$router->match(array('board-(:board)/message-(:msg)/delete' => 'message#delete_'));
	$router->match(array('board-(:board)/message-(:msg)/reply(.:format)' => 'message#reply'));
	$router->match(array('board-(:board)/message-(:msg)/reply-(:reply)/delete(.:format)' => 'message#reply_del'));
	$router->match(array('board-(:board)/message-(:msg)/reply-(:reply)/edit(.:format)' => 'message#reply_edit'));
	$router->match(array('board-(:board)/message-(:msg)(/page-:page)(.:format)' => 'message#index'));
});
?>
