<?php

namespace App\Models\Service\User;
use App\Models\User;

class UserService
{
    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }
  
    public function create(array $data)
    {
        try{
            return  $user = $this->user->create($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }
  
      public function find($id)
      {
          try{
             return  $user = $this->user->find($id);
          }
          catch (\Exception $e)
          {
              return false;
          }
      }
  
      public function update($id,array $data)
      {
          try{
              $user = $this->user->find($id);
              return  $user = $user->update($data);
          }
          catch (\Exception $e)
          {
              return false;
          }
      }
  
      public function delete($id)
      {
          try{
              $user = $this->user->find($id);
              return  $user = $user->delete();
          }
          catch (\Exception $e)
          {
              return false;
          }
      }
}
