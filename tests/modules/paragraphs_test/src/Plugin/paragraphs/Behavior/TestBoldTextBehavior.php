<?php

namespace Drupal\paragraphs_test\Plugin\paragraphs\Behavior;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\paragraphs\Entity\ParagraphsType;
use Drupal\paragraphs\ParagraphsBehaviorBase;

/**
 * Provides a test feature plugin.
 *
 * @ParagraphsBehavior(
 *   id = "test_bold_text",
 *   label = @Translation("Test bold text plugin"),
 *   description = @Translation("Test bold text plugin"),
 *   weight = 2
 * )
 */
class TestBoldTextBehavior extends ParagraphsBehaviorBase {

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(Paragraph $paragraphs_entity) {
    $form['bold_text'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Bold Text'),
      '#default_value' => $paragraphs_entity->getBehaviorSetting($this->getPluginId(), 'bold_text', FALSE),
      '#description' => $this->t("Bold text for the paragraph."),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateBehaviorForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitBehaviorForm(Paragraph $paragraphs_entity, array $values) {
    $paragraphs_entity->setBehaviorSettings($this->getPluginId(), $values);
  }

  /**
   * {@inheritdoc}
   */
  public function view(array &$build, Paragraph $paragraphs_entity, EntityViewDisplayInterface $display, $view_mode) {
    if ($paragraphs_entity->getBehaviorSetting($this->getPluginId(), 'bold_text')) {
      $build['#attributes']['class'][] = 'bold_plugin_text';
      $build['#attached']['library'][] = 'paragraphs_test/drupal.paragraphs_test.bold_text';
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(ParagraphsType $paragraphs_type) {
    // If the name of the field is not text_paragraph_test then allow using this
    // plugin.
    if ($paragraphs_type->id() != 'text_paragraph_test') {
      return TRUE;
    }
    return FALSE;
  }

}