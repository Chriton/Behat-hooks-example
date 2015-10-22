#In order to [benefit], as a [stakeholder] I want to [feature]

	Feature: Change first & last name
		In order to buy and receive products
		As a customer
		I want to be able to change my first & last name

	@javascript @before_hook_log_in @after_hook_restore_first_and_lastname
	Scenario: Edit first & last name
		Given I am on the Edit Contact Information page
		When I edit my first and last name
		And I log out
		Then I should see the new data when I log in

