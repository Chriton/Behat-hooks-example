#In order to [benefit], as a [stakeholder] I want to [feature]

	Feature: Change password
		In order to buy and receive products
		As a customer
		I want to be able to change my password

	@javascript @before_hook_log_in @after_hook_restore_password
	Scenario: Change the password
		Given I am on the Change Password page
		When I change the password
		Then I should be able to log in with the new password




