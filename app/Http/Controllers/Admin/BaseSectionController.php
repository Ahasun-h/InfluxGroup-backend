<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

abstract class BaseSectionController extends Controller
{
    abstract protected function getModelClass();
    abstract protected function getViewsPrefix();
    abstract protected function getRoutePrefix();
    abstract protected function getValidationRules(Request $request);

    public function index()
    {
        $modelClass = $this->getModelClass();
        $sections = $modelClass::latest()->get();
        $viewsPrefix = $this->getViewsPrefix();

        return view("admin.{$viewsPrefix}.index", compact('sections'));
    }

    public function create()
    {
        $viewsPrefix = $this->getViewsPrefix();
        return view("admin.{$viewsPrefix}.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules($request));
        $modelClass = $this->getModelClass();

        if ($request->hasFile('background_image')) {
            $validated['background_image'] = $request->file('background_image')->store($this->getStoragePath(), 'public');
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store($this->getStoragePath(), 'public');
        }

        $modelClass::create($validated);

        return redirect()->route($this->getRoutePrefix() . '.index')
            ->with('success', $this->getSuccessMessage('created'));
    }

    public function edit($id)
    {
        $modelClass = $this->getModelClass();
        $section = $modelClass::findOrFail($id);
        $viewsPrefix = $this->getViewsPrefix();

        return view("admin.{$viewsPrefix}.edit", compact('section'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->getValidationRules($request));
        $modelClass = $this->getModelClass();
        $section = $modelClass::findOrFail($id);

        if ($request->hasFile('background_image')) {
            if ($section->background_image) {
                Storage::disk('public')->delete($section->background_image);
            }
            $validated['background_image'] = $request->file('background_image')->store($this->getStoragePath(), 'public');
        }

        if ($request->hasFile('image')) {
            if ($section->image) {
                Storage::disk('public')->delete($section->image);
            }
            $validated['image'] = $request->file('image')->store($this->getStoragePath(), 'public');
        }

        $section->update($validated);

        return redirect()->route($this->getRoutePrefix() . '.index')
            ->with('success', $this->getSuccessMessage('updated'));
    }

    public function destroy($id)
    {
        $modelClass = $this->getModelClass();
        $section = $modelClass::findOrFail($id);

        if ($section->background_image) {
            Storage::disk('public')->delete($section->background_image);
        }

        if ($section->image) {
            Storage::disk('public')->delete($section->image);
        }

        $section->delete();

        return redirect()->route($this->getRoutePrefix() . '.index')
            ->with('success', $this->getSuccessMessage('deleted'));
    }

    public function toggleStatus($id)
    {
        $modelClass = $this->getModelClass();
        $section = $modelClass::findOrFail($id);

        $section->update(['is_active' => !$section->is_active]);

        return redirect()->route($this->getRoutePrefix() . '.index')
            ->with('success', $this->getSuccessMessage('status updated'));
    }

    protected function getStoragePath()
    {
        return 'sections';
    }

    protected function getSuccessMessage($action)
    {
        return "Section {$action} successfully.";
    }
}
