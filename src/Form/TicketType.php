<?php
namespace App\Form;
use App\Entity\Ticket;
use App\Entity\Orders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('country', CountryType::class, [
                'placeholder' => 'Selectionnez votre pays',
                'label'=>'Pays'
                ])
                ->add('reducedPrice', CheckboxType::class,[
                    'label'=>'Tarif réduit'])

                ->add('birthDate', DateType::class, [
                      'widget' => 'single_text',
                      'html5' => false,
                      'label'=>'Date de naissance',
                      'attr' => ['class' => 'js-datepicker'],
                ])
               ->add('name', TextType::class,[
                    'label'=>'Nom'])
            ->add('ticketType',  ChoiceType::class, [
                'label'=>'Type de billet',
                'choices' => [
                    'Billet journée' => "Billet journée",
                    'Billet demi-journée' => "Billet demi-journée",
                ]]) 
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}