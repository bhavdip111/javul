<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobSkillsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_skills_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix_id')->nullable();
            $table->integer('job_skill_id')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('skill_name')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('parent_id_belongs_to',20)->nullable();
            $table->text('skill_hierarchy')->nullable();
            $table->string('action_type')->comment='added,deleted or updated';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_skills_history');
    }
}
