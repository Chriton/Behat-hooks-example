<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;


use Behat\MinkExtension\Context\MinkContext;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */

class FeatureContext extends MinkContext
{
	const LOGIN_EMAIL = 'doru@xlteam.nl';
	const CHANGED_EMAIL = 'doru.muntean@xlteam.nl';

	const LOGIN_PASSWORD = 'tester';
	const CHANGED_PASSWORD = 'newpassword';

	const FIRST_NAME = 'first name';
	const LAST_NAME = 'last name';
	const CHANGED_FIRST_NAME = 'new first name';
	const CHANGED_LAST_NAME = 'new last name';

	const SAVE_BUTTON = 'Save';
	const LOGIN_BUTTON = 'send2';

	const SAVED_SUCCESSFULLY = 'The account information has been saved';
	const DASHBOARD_TEXT = 'My Account Dashboard';

	/**
	 * Initializes context.
	 * Every scenario gets it's own context object.
	 *
	 * @param array $parameters context parameters (set them up through behat.yml)
	 */
	public function __construct(array $parameters)
	{
		// Initialize your context here
	}

	/**
	 * @param string $username
	 * @param string $password
	 */
	public function login($username = self::LOGIN_EMAIL,$password = self::LOGIN_PASSWORD)
	{
		$this->visit("/customer/account/logout/");
		$this->visit("/customer/account/login/");
		$this->fillField('login[username]',$username);
		$this->fillField('login[password]',$password);
		$this->pressButton(self::LOGIN_BUTTON);
		sleep(2);
	}

	/**
	 *
	 */
	public function logout()
	{
		$this->visit("/customer/account/logout/");
	}


	/**
	 * @BeforeScenario @before_hook_log_in
	 */
	public function before_scenario()
	{
		//this will only run before the scenario with the tag @before_hook_log_in

		$this->login(self::LOGIN_EMAIL,self::LOGIN_PASSWORD);
	}

	/**
	 * @AfterScenario @after_hook_restore_first_and_lastname
	 */
	public function restore_first_and_lastname()
	{
		//this will only run after the scenario with the tag @after_hook_restore_first_and_lastname

		//log in
		$this->login(self::LOGIN_EMAIL,self::LOGIN_PASSWORD);

		//are we logged in?
		$this->assertPageContainsText(self::DASHBOARD_TEXT);

		//change back the firstname and lastname
		$this->visit("customer/account/edit/");
		$this->fillField('firstname',self::FIRST_NAME);
		$this->fillField('lastname',self::LAST_NAME);

		$this->pressButton(self::SAVE_BUTTON);
		sleep(3);

		$this->assertPageContainsText(self::SAVED_SUCCESSFULLY);
	}

	/**
	 * @AfterScenario @after_hook_restore_password
	 */
	public function restore_password()
	{
		//this will only run after the scenario with the tag @after_hook_restore_password

		//log in
		$this->login(self::LOGIN_EMAIL,self::CHANGED_PASSWORD);

		//are we logged in?
		$this->assertPageContainsText(self::DASHBOARD_TEXT);

		//change back the password
		$this->visit("customer/account/edit/changepass/1/");
		$this->fillField('current_password',self::CHANGED_PASSWORD);
		$this->fillField('password',self::LOGIN_PASSWORD);
		$this->fillField('confirmation',self::LOGIN_PASSWORD);

		$this->pressButton(self::SAVE_BUTTON);
		sleep(3);
		$this->assertPageContainsText(self::SAVED_SUCCESSFULLY);
		}

	/**
	 * @AfterScenario @after_hook_restore_email
	 */
	public function restore_email()
	{
		//this will only run after the scenario with the tag @after_hook_restore_email

		//login with the changed email
		$this->login(self::CHANGED_EMAIL,self::LOGIN_PASSWORD);

		//are we logged in?
		$this->assertPageContainsText(self::DASHBOARD_TEXT);

		//change back the email
		$this->visit("customer/account/edit/");
		$this->fillField('email',self::LOGIN_EMAIL);
		$this->pressButton(self::SAVE_BUTTON);
		sleep(3);
		$this->assertPageContainsText(self::SAVED_SUCCESSFULLY);
	}

	/**
	 * @Given /^I am on the Change Password page$/
	 */
	public function iAmOnTheChangePasswordPage()
	{
		$this->visit("customer/account/edit/changepass/1/");
	}

	/**
	 * @When /^I change the password$/
	 */
	public function iChangeThePassword()
	{
		$this->fillField('current_password',self::LOGIN_PASSWORD);
		$this->fillField('password',self::CHANGED_PASSWORD);
		$this->fillField('confirmation',self::CHANGED_PASSWORD);

		$this->pressButton(self::SAVE_BUTTON);
		sleep(3);
		$this->assertPageContainsText(self::SAVED_SUCCESSFULLY);
	}

	/**
	 * @Then /^I should be able to log in with the new password$/
	 */
	public function iShouldBeAbleToLogInWithTheNewPassword()
	{
		$this->login(self::LOGIN_EMAIL,self::CHANGED_PASSWORD);
		$this->assertPageContainsText(self::DASHBOARD_TEXT);
	}

	/**
	 * @Given /^I am on the Edit Contact Information page$/
	 */
	public function iAmOnTheEditContactInformationPage()
	{
		$this->visit("customer/account/edit/");
	}

	/**
	 * @When /^I change the email address$/
	 */
	public function iChangeTheEmailAddress()
	{
		$this->fillField('email',self::CHANGED_EMAIL);
		$this->pressButton(self::SAVE_BUTTON);
		sleep(3);
		$this->assertPageContainsText(self::SAVED_SUCCESSFULLY);
	}

	/**
	 * @Then /^I should be able to log in with the new email$/
	 */
	public function iShouldBeAbleToLogInWithTheNewEmail1()
	{
		$this->login(self::CHANGED_EMAIL,self::LOGIN_PASSWORD);
		$this->assertPageContainsText(self::DASHBOARD_TEXT);
	}

	/**
	 * @When /^I edit my first and last name$/
	 */
	public function iEditMyFirstAndLastName()
	{
		$this->fillField('firstname',self::CHANGED_FIRST_NAME);
		$this->fillField('lastname',self::CHANGED_LAST_NAME);

		$this->pressButton(self::SAVE_BUTTON);
		sleep(3);

		$this->assertPageContainsText(self::SAVED_SUCCESSFULLY);
	}

	/**
	 * @Given /^I log out$/
	 */
	public function iLogOut()
	{
		$this->logout();
	}

	/**
	 * @Then /^I should see the new data when I log in$/
	 */
	public function iShouldSeeTheNewDataWhenILogIn()
	{
		$this->login(self::LOGIN_EMAIL,self::LOGIN_PASSWORD);
		$this->visit("customer/account/edit/");
		$this->assertFieldContains('firstname',self::CHANGED_FIRST_NAME);
		$this->assertFieldContains('lastname',self::CHANGED_LAST_NAME);
	}

}


