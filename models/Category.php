<?php
require_once(__DIR__ . "/Model.php");
class Category extends Model {
    protected static string $table = "categories";
    protected static string $primary_key = "id";
    private int $id;
    private string $name;

    public function __construct(array $data)
    { 
        $this->id = $data['id'];
        $this->name = $data['name'];
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }

}