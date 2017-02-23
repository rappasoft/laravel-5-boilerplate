<?php

use Tests\BrowserKitTestCase;
use App\Models\Access\User\User;

/**
 * Class HistoryRenderEntityTest.
 */
class HistoryRenderEntityTest extends BrowserKitTestCase
{
    public function testViewOnlyHasHistoryOfEntity()
    {
        $this->actingAs($this->admin);

        $test_user = factory(User::class)->create();

        history()
            ->withType('User')
            ->withText('__("created user") '.$this->user->name)
            ->withEntity($this->user->id)
            ->withIcon('plus')
            ->withClass('bg-green')
            ->log();

        history()
            ->withType('User')
            ->withText('__("updated user") '.$this->user->name)
            ->withEntity($this->user->id)
            ->withIcon('pencil')
            ->withClass('bg-blue')
            ->log();

        history()
            ->withType('User')
            ->withText('__("deleted user") '.$this->user->name)
            ->withEntity($this->user->id)
            ->withIcon('trash')
            ->withClass('bg-red')
            ->log();

        history()
            ->withType('User')
            ->withText('__("created role") '.$test_user->name)
            ->withEntity($test_user->id)
            ->withIcon('plus')
            ->withClass('bg-red')
            ->log();

        history()
            ->withType('User')
            ->withText('__("updated role") '.$test_user->name)
            ->withEntity($test_user->id)
            ->withIcon('pencil')
            ->withClass('bg-red')
            ->log();

        history()
            ->withType('User')
            ->withText('__("deleted role") '.$test_user->name)
            ->withEntity($test_user->id)
            ->withIcon('trash')
            ->withClass('bg-red')
            ->log();

        $this->visit('/admin/access/user/'.$this->user->id)
             ->see('<strong>'.$this->admin->name.'</strong> created user '.$this->user->name)
             ->see('<strong>'.$this->admin->name.'</strong> updated user '.$this->user->name)
             ->see('<strong>'.$this->admin->name.'</strong> deleted user '.$this->user->name)
             ->dontSee('<strong>'.$this->admin->name.'</strong> created user '.$test_user->name)
             ->dontSee('<strong>'.$this->admin->name.'</strong> updated user '.$test_user->name)
             ->dontSee('<strong>'.$this->admin->name.'</strong> deleted user '.$test_user->name);
    }
}
