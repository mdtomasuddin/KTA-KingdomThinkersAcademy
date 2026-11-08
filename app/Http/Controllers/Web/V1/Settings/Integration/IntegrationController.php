<?php

namespace App\Http\Controllers\Web\V1\Settings\Integration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\V1\Settings\Integration\IntegrationSettingRequest;
use App\Services\Web\V1\Settings\Integration\IntegrationService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;

class IntegrationController extends Controller
{
    /**
     * IntegrationController constructor.
     */
    public function __construct(
        protected IntegrationService $integrationService
    ) {}

    /**
     * Display integration settings page.
     */
    public function index(): View
    {
        return view('backend.settings.integration.index');
    }

    /**
     * Update Google OAuth credentials.
     */
    public function updateGoogleCredentials(IntegrationSettingRequest $request): RedirectResponse
    {
        try {
            $this->integrationService->updateGoogleCredentials($request->validated());

            return redirect()->back()->with(['t-success' => 'Google settings updated successfully.', 'active_tab' => 'google']);
        } catch (Exception $e) {
            return redirect()->back()->with(['t-error' => 'Failed to update Google settings: ' . $e->getMessage(), 'active_tab' => 'google']);
        }
    }

    /**
     * Update Facebook OAuth credentials.
     */
    public function updateFacebookCredentials(IntegrationSettingRequest $request): RedirectResponse
    {
        try {
            $this->integrationService->updateFacebookCredentials($request->validated());

            return redirect()->back()->with(['t-success' => 'Facebook settings updated successfully.', 'active_tab' => 'facebook']);
        } catch (Exception $e) {
            return redirect()->back()->with(['t-error' => 'Failed to update Facebook settings: ' . $e->getMessage(), 'active_tab' => 'facebook']);
        }
    }

    /**
     * Update Apple Sign-In credentials.
     */
    public function updateAppleCredentials(IntegrationSettingRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('apple_key_file')) {
                $file            = $request->file('apple_key_file');
                $keyId           = $request->input('APPLE_KEY_ID') ?: 'apple';
                $fileName        = $file->getClientOriginalName() ?: ('AuthKey_' . $keyId . '.p8');
                $destinationPath = storage_path('app/private');

                if (! File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $fileName);
                $data['APPLE_PRIVATE_KEY'] = 'app/private/' . $fileName;
            }

            $this->integrationService->updateAppleCredentials($data);

            return redirect()->back()->with(['t-success' => 'Apple settings updated successfully.', 'active_tab' => 'apple']);
        } catch (Exception $e) {
            return redirect()->back()->with(['t-error' => 'Failed to update Apple settings: ' . $e->getMessage(), 'active_tab' => 'apple']);
        }
    }

    /**
     * Update Twilio credentials.
     */
    public function updateTwilioCredentials(IntegrationSettingRequest $request): RedirectResponse
    {
        try {
            $this->integrationService->updateTwilioCredentials($request->validated());

            return redirect()->back()->with(['t-success' => 'Twilio settings updated successfully.', 'active_tab' => 'twilio']);
        } catch (Exception $e) {
            return redirect()->back()->with(['t-error' => 'Failed to update Twilio settings: ' . $e->getMessage(), 'active_tab' => 'twilio']);
        }
    }

    /**
     * Update Stripe API keys.
     */
    public function updateStripeCredentials(IntegrationSettingRequest $request): RedirectResponse
    {
        try {
            $this->integrationService->updateStripeCredentials($request->validated());

            return redirect()->back()->with(['t-success' => 'Stripe settings updated successfully.', 'active_tab' => 'stripe']);
        } catch (Exception $e) {
            return redirect()->back()->with(['t-error' => 'Failed to update Stripe settings: ' . $e->getMessage(), 'active_tab' => 'stripe']);
        }
    }

    /**
     * Update OpenAI credentials.
     */
    public function updateOpenAiCredentials(IntegrationSettingRequest $request): RedirectResponse
    {
        try {
            $this->integrationService->updateOpenAiCredentials($request->validated());

            return redirect()->back()->with(['t-success' => 'OpenAI settings updated successfully.', 'active_tab' => 'openai']);
        } catch (Exception $e) {
            return redirect()->back()->with(['t-error' => 'Failed to update OpenAI settings: ' . $e->getMessage(), 'active_tab' => 'openai']);
        }
    }
}

