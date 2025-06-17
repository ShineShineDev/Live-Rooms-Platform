<?php

namespace Database\Seeders;

use App\Models\Rooms;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "title" => "Team A vs Team B",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "sports",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM A",
                "team_b" => "TEAM B",
                "commentator" => "BLV NONAME",
                "is_live" => true,
                "is_hot" => true
            ],
            [
                "title" => "Team C vs Team D",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "sports",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM C",
                "team_b" => "TEAM D",
                "commentator" => "BLV NONAME",
                "is_live" => false,
                "is_hot" => true
            ],
            [
                "title" => "Team iwe vs Team Dwe",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "sports",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM iwe",
                "team_b" => "TEAM Dwe",
                "commentator" => "BLV NONAME",
                "is_live" => true,
                "is_hot" => true
            ],
            [
                "title" => "Team iwe vs Team cse",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "sports",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM iwe",
                "team_b" => "TEAM cse",
                "commentator" => "BLV NONAME",
                "is_live" => false,
                "is_hot" => true
            ],

            [
                "title" => "Team iosc vs Team nclsd",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "gaming",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM iosc",
                "team_b" => "TEAM nclsd",
                "commentator" => "BLV NONAME",
                "is_live" => true,
                "is_hot" => false
            ],
            [
                "title" => "Team qwec vs Team mwepx",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "gaming",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM qwec",
                "team_b" => "TEAM mwepx",
                "commentator" => "BLV NONAME",
                "is_live" => true,
                "is_hot" => false
            ],
            [
                "title" => "Team kmsad vs Team 2323",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "gaming",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM kmsad",
                "team_b" => "TEAM 2323",
                "commentator" => "BLV NONAME",
                "is_live" => false,
                "is_hot" => true
            ],
            [
                "title" => "Team 923 vs Team ksd",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "gaming",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM kmsad",
                "team_b" => "TEAM 2323",
                "commentator" => "BLV NONAME",
                "is_live" => false,
                "is_hot" => false
            ],
            [
                "title" => "Team xsld vs Team sad",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "gaming",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM xsld",
                "team_b" => "TEAM sad",
                "commentator" => "BLV NONAME",
                "is_live" => true,
                "is_hot" => true
            ],


            [
                "title" => "Team 122 vs Team 23c",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "entertainment",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM 23c",
                "team_b" => "TEAM 32c",
                "commentator" => "BLV NONAME",
                "is_live" => false,
                "is_hot" => true
            ],
            [
                "title" => "Team 3pc vs Team 23l",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "entertainment",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM 3pc",
                "team_b" => "TEAM 23l",
                "commentator" => "BLV NONAME",
                "is_live" => true,
                "is_hot" => true
            ],
            [
                "title" => "Team kmsad vs Team 2323",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "entertainment",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM kmsad",
                "team_b" => "TEAM 2323",
                "commentator" => "BLV NONAME",
                "is_live" => false,
                "is_hot" => false
            ],
            [
                "title" => "Team 923 vs Team ksd",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "entertainment",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM kmsad",
                "team_b" => "TEAM 2323",
                "commentator" => "BLV NONAME",
                "is_live" => false,
                "is_hot" => true
            ],
            [
                "title" => "Team xsld vs Team sad",
                "image_url" => "https://i.ytimg.com/vi/vH8Kn1Hs_FE/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBZmq2lV-QyfgseHRU1-sJv7m58DA",
                "category" => "entertainment",
                "date" => "2013-06-26",
                "time" => "19:00",
                "team_a" => "TEAM xsld",
                "team_b" => "TEAM sad",
                "commentator" => "BLV NONAME",
                "is_live" => true,
                "is_hot" => true
            ],
        ];
        Rooms::insert($data);
    }
}
