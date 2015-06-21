<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_AdminClient extends Controller_Async
    {

        public function before()
        {
            parent::before();
        }

        public function action_save()
        {
            $id = $this->request->param('id');

            $name       = $this->request->post('name');
            $address    = $this->request->post('address');
            $phone      = $this->request->post('phone');
            $email       = $this->request->post('email');

            $client = ORM::factory('Client', $id);

            $client->name = $name;
            $client->address = $address;
            $client->phone = $phone;
            $client->email = $email;

            $client->save();

            $this->data['success'] = true;
            $this->data['feedback'] = 'Enregistrement reussi';
        }

        public function action_search()
        {
            $query = $this->request->param('id');

            $keywords = explode(' ', $query);

            $clients = ORM::factory('Client')->where_open();
            foreach ($keywords as $kw)
            {
                $clients->where('name', 'LIKE', '%'.$kw.'%');
            }
            $clients->where_close();

            $clients->or_where('email', 'LIKE', '%'.$query.'%');

            $clients = $clients->limit(10)->find_all();

            $results = [];
            foreach ($clients as $client)
            {
                $result = [];
                $result['name'] = $client->name;
                $result['ID'] = $client->pk();
                $result['address'] = $client->address;
                $result['email'] = $client->email;
                $result['phone'] = $client->phone;
                array_push($results, $result);
            }

            $this->data['success'] = true;
            $this->data['results'] = $results;
        }

        public function action_allNames()
        {
            $clients = ORM::factory('Client')->find_all();

            $result = [];
            foreach ($clients as $client)
            {
                array_push($result, $client->name);
            }

            $this->data = $result;
        }
    }