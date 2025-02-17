# Password Requirements Constraint

<secondary-label ref="2.0.0" />

A validator for a consistent password across the application

## Usage

```php
namespace App\Form;

use Idm\Bundle\User\Validator\Constraint\PasswordRequirements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

final class ChangePasswordFormType extends AbstractType
{
	public function buildForm (FormBuilderInterface $builder, array $options): void
	{
		$builder
		    // ...
			->add('newPassword', PasswordType::class, [
				'constraints'     => [
					new PasswordRequirements(),
				],
				'mapped'          => false,
			])
			// ...
		;
	}

	// ...
}
```
