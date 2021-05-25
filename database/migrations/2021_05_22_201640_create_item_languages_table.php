<?php

use App\Character;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemLanguagesTable extends Migration
{
    protected $races = [
        'Blood Elf' => Character::RACE_BLOOD_ELF,
        'Orc' => Character::RACE_ORC,
        'Tauren' => Character::RACE_TAUREN,
        'Troll' => Character::RACE_TROLL,
        'Undead' => Character::RACE_UNDEAD,
        'Draenei' => Character::RACE_DRAENEI,
        'Dwarf' => Character::RACE_DWARF,
        'Gnome' => Character::RACE_GNOME,
        'Human' => Character::RACE_HUMAN,
        'Night Elf' => Character::RACE_NIGHT_ELF,
    ];

    protected $classes = [
        'Death Knight' => Character::CLASS_DEATH_KNIGHT,
        'Druid' => Character::CLASS_DRUID,
        'Hunter' => Character::CLASS_HUNTER,
        'Mage' => Character::CLASS_MAGE,
        'Paladin' => Character::CLASS_PALADIN,
        'Priest' => Character::CLASS_PRIEST,
        'Rogue' => Character::CLASS_ROGUE,
        'Shaman' => Character::CLASS_SHAMAN,
        'Warlock' => Character::CLASS_WARLOCK,
        'Warrior' => Character::CLASS_WARRIOR,
    ];

    protected $professions = [
        'Alchemy' => Character::PROFESSION_ALCHEMY,
        'Blacksmithing' => Character::PROFESSION_BLACKSMITHING,
        'Enchanting' => Character::PROFESSION_ENCHANTING,
        'Engineering' => Character::PROFESSION_ENGINEERING,
        'Herbalism' => Character::PROFESSION_HERBALISM,
        'Inscription' => Character::PROFESSION_INSCRIPTION,
        'Jewelcrafting' => Character::PROFESSION_JEWELCRAFTING,
        'Leatherworking' => Character::PROFESSION_LEATHERWORKING,
        'Mining' => Character::PROFESSION_MINING,
        'Skinning' => Character::PROFESSION_SKINNING,
        'Tailoring' => Character::PROFESSION_TAILORING
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_languages', function (Blueprint $table) {
            $table->mediumInteger('item_id')->unsigned();
            $table->string('language', 2);
            $table->string('name', 500);
            $table->timestamps();

            $table->foreign('item_id')->references('item_id')->on('items');
            $table->primary(['item_id', 'language']);
        });

        foreach ($this->races as $language => $trans){
            Character::where('race', $language)
                ->update([
                    'race' => $trans
                ]);
        }
        foreach ($this->classes as $language => $trans){
            Character::where('class', $language)
                ->update([
                    'class' => $trans
                ]);
        }
        foreach ($this->races as $language => $trans){
            Character::where('profession_1', $language)
                ->update([
                    'profession_1' => $trans
                ]);
            Character::where('profession_2', $language)
                ->update([
                    'profession_2' => $trans
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_languages');
    }
}
