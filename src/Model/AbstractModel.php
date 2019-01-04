<?php


namespace App\Model;


abstract class AbstractModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * AbstractModel constructor.
     *
     * @param array $data
     */
    public function __construct($data =[])
    {
        if(!empty($data))
        {
            $this->hydrate($data);
        }
    }

    /**
     * @param array $data
     */
    protected function hydrate(array $data)
    {
        foreach($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (is_callable([$this, $method]))
            {
                $this->$method($value);
            }
        }
    }

    // SETTERS /

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    // GETTERS //

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    protected function setDateTime($value)
    {
        if (is_string($value)) {
            return DateTime::createFromFormat('Y-m-d H:i:s', $value);
        }
        return $value;
    }
}