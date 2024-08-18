<?php

namespace EbanxChallenge\Core {

    use \EbanxChallenge\Core\Web\Context;

    abstract class ModelBase
    {
        /**
         * @var array $data The data array used to store fake database rows.
         */
        protected array $data;

        /**
         * Constructor for the ModelBase class.
         */
        public function __construct()
        {
            $content = file_get_contents($this->getFilePath());
            $this->data = json_decode($content, true);
        } 

        /**
         * Retrieves the file path of the Model class.
         *
         * @return string The file path.
         */
        private function getFilePath() : string
        {
            return Context::$application->mapAbsolutePath("Database/" . $this->getTableName() . ".json");
        }

        /**
         * Retrieves the original file path.
         *
         * @return string The original file path.
         */
        private function getOriginalFilePath() : string
        {
            return Context::$application->mapAbsolutePath("Database/" . $this->getTableName() . ".origin.json");
        }

        /**
         * Retrieves the name of the table associated with the model.
         *
         * @return string The name of the table.
         */
        abstract public function getTableName() : string;

        /**
         * Retrieves all rows of fake database
         *
         * @return array The list of rows.
         */
        public function list() : array
        {
            return $this->data;
        }

        /**
         * Selects rows from the database based on a specific column and value.
         *
         * @param string $columnName The name of the column to search in.
         * @param string $value The value to search for in the specified column.
         * @return array An array of rows that match the search criteria.
         */
        public function select(string $columnName, string $value) : array
        {
            $results = array();

            foreach($this->data as $row)
            {
                if($row[$columnName] == $value)
                {
                    $results[] = $row;
                }
            }

            return $results;
        }

        public function indexOf(string $columnName, string $value) : int | false
        {
            for($i = 0; $i < count($this->data); $i++)
            {
                if($this->data[$i][$columnName] == $value)
                {
                    return $i;
                }
            }
            return false;
        }

        public function persist() : void{
            $content = \json_encode($this->data, JSON_PRETTY_PRINT);
            file_put_contents($this->getFilePath(), $content);
        }

        public function reset() : void{
            copy($this->getOriginalFilePath(), $this->getFilePath());
        }

    }
}
