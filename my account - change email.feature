#In order to [benefit], as a [stakeholder] I want to [feature]

	Feature: Change email address
		In order to buy and receive products
		As a customer
		I want to be able to change my email address

	@javascript @before_hook_log_in @after_hook_restore_email
	Scenario: Change email address
		Given I am on the Edit Contact Information page
		When I change the email address
		Then I should be able to log in with the new email


