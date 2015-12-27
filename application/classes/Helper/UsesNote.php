<?php defined('SYSPATH') or die('No direct script access.');

    // Overrides get/set for use with Model_Note
    // MUST USE a $_belongs_to : 'note_item' => ['model' => 'Note', 'foreign_key' => 'noteID'
    class Helper_UsesNote extends ORM
    {
        protected $note_changed = false;

        public function __get($parameter)
        {
            if ($parameter == 'note')
            {
                return $this->note_item->loaded() ? $this->note_item->value : '';
            }
            else
            {
                return parent::__get($parameter);
            }
        }

        public function __set($parameter, $value)
        {
            if ($parameter == 'note')
            {
                $note = $this->note_item;
                if (!$note->loaded())
                {
                    $note = ORM::factory('Note');
                    $note->save();
                    $this->noteID = $note->pk();
                }
                $note->value = $value;
                $this->note_changed = true;
            }
            else
            {
                parent::__set($parameter, $value);
            }
        }

        // Dépendance inversée... Pas bon...
        public function save(Validation $validation = NULL)
        {
            if ($this->note_item->loaded())
            {
                $this->note_item->save();
            }

            parent::save($validation);
        }
    }