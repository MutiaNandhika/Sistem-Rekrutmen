use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->float('saw_c1')->nullable();
            $table->float('saw_c2')->nullable();
            $table->float('saw_c3')->nullable();
            $table->float('saw_score')->nullable();
            $table->integer('saw_rank')->nullable();
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'saw_c1','saw_c2','saw_c3','saw_score','saw_rank'
            ]);
        });
    }
};
