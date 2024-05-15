<?php

namespace App\Table;

use App\Core\Table;
use App\Core\Interface\ITable;
use App\Core\TableTrait\TDelete;
use App\Core\TableTrait\TInsert;
use App\Core\TableTrait\TSelect;
use App\Core\TableTrait\TUpdate;

class ContactTable extends Table implements ITable
{
    use TInsert;
    use TDelete;
    use TUpdate;
    use TSelect;


    public int $id;
    public int $user_id;
    public string $name;
    public ?string $tel;
    public ?string $email;
    public ?string $address;
    public function __construct()
    {
        $this->address = null;
        $this->email = null;
        $this->tel = null;
        parent::__construct();
    }

    public function getTable(): string
    {
        return 'contacts';
    }

    /**
     * @return false|array<$this>
     */
    public function selectLikeByName(): array|false
    {
        return $this->select()->where('user_id', $this->user_id)->whereLike('name', $this->name)->orderBy()->run();
    }

    /**
    * @return false|array<$this>
    */
    public function selectAllByUser(): false|array
    {
        return $this->select()->where('user_id', $this->user_id)->orderBy()->run();
    }
}
