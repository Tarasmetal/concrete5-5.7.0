<?
defined('C5_EXECUTE') or die("Access Denied.");

class Concrete5_Controller_Page_Dashboard_System_Registration extends DashboardController {

	public function view(){
		$this->redirect('/dashboard/system/registration/public_registration/');
	}
}