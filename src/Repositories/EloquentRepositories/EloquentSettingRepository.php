<?php 

namespace Surya\Setting\Repositories\EloquentRepositories;

use Surya\Setting\Repositories\SettingRepository;
use Surya\Setting\Models\Setting;

class EloquentSettingRepository implements SettingRepository {

    private $model;

    public function __construct()
    {
        $this->model = new Setting;
    }

    /**
     * Get all settings from database
     * 
     * @return Illuminate\Support\Collection
     */

    public function all(array $cols = [])
    {
        if (count($cols) > 0) {
            return $this->model->select($cols)->get();         
        }
        return $this->model->all();
    }

    /**
     * Find setting by id
     * 
     * @return Surya\Setting\Model\Setting
     */

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Insert new setting
     * 
     * @return Surya\Setting\Model\Setting
     */

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Get setting object from database
     * 
     * @param string $group
     * @param string $name
     * @return Surya\Setting\Model\Setting
     */

    public function getSetting(string $group, string $name)
    {
        return $this->model
                    ->select(['id', 'group', 'name', 'value'])
                    ->where('group', $group)
                    ->where('name', $name)
                    ->first();
    }

    /**
     * Get setting value from database
     * 
     * @param string $group
     * @param string $name
     * @return mix
     */

    public function get(string $group, string $name)
    {
        $setting = $this->getSetting($group, $name);
        if (setting($group . '.' . $name . '.type') == 'check') {
            return ($setting) ? explode(',', $setting->value) : setting($group . '.' . $name . '.' . 'default');
        }
        return ($setting) ? $setting->value : setting($group . '.' . $name . '.' . 'default');
    }

    /**
     * Get settings value based on given group from database
     * 
     * @param string $group
     * @param array $cols
     * @return Illuminate\Support\Collection
     */

    public function getByGroup(string $group, array $cols = ['name', 'value'])
    {
        return $this->model->select($cols)->where('group', $group)->orderBy('name')->get();
    }

    /**
     * Save settings
     * 
     * @param array $data
     * @return void
     */

    public function save(array $data)
    {
        // dd($data);
        $len = count($data['name']);
        for ($i=0; $i < $len; $i++) {

            $setting = $this->model->where('name', $data['name'][$i])->where('group', $data['group'])->first();
            
            
            if (isset($data[$data['name'][$i]])) {

                if ($data[$data['name'][$i]] instanceof \Illuminate\Http\UploadedFile) {
                    $data[$data['name'][$i]] = $this->handleFileUpload($data[$data['name'][$i]]);
                }

                if (!$setting) {
                    $setting = $this->model->create([
                        'group' => $data['group'],
                        'name' => $data['name'][$i]
                    ]);
                }
            }else {

                if (setting($data['group'].'.'.$data['name'][$i].'.type') === 'file') {
                    $data[$data['name'][$i]] = $setting->value;
                }
            }

            if (is_array($data[$data['name'][$i]])) {
                $setting->value = implode(',', array_keys($data[$data['name'][$i]]));
            }else {
                $setting->value = $data[$data['name'][$i]];
            }

            $setting->save();

        }
    }

    /**
     * Check if setting exists
     * 
     * @param string $group
     * @param string $name
     * @return boolean
     */

    public function ifExists(string $group, string $name){
        return $this->model
                    ->select('id')
                    ->where('group', $group)->where('name', $name)
                    ->first() ? true : false;
    }

    /**
     * Handle file upload for file
     * 
     * @param Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function handleFileUpload(Illuminate\Http\UploadedFile $file) {
        $filename = $file->getClientOriginalName();

        return $file->storeAs('public/uploads', $filename);
    }

}