<?php

namespace App\Form\Type;

use App\Form\DataTransformer\IssueToNumberTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

// ...
class TaskType extends AbstractType
{
    private $transformer;

    public function __construct(IssueToNumberTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType :: class)
            ->add('issue', TextType :: class, [
                // validation message if the data transformer fails
                'invalid_message' => 'That is not a valid issue number',
            ]);

        $builder->get('issue')
            ->addModelTransformer($this->transformer);
    }
}
