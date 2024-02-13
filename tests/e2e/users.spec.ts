import { test } from '@playwright/test';
import common from './common';

test('Admin user can reset password', async ({ page }) => {
  await page.goto(`${common.appUrl}/login`);
  await page.getByRole('link', { name: 'Forgot your password?' }).click();
  await page.getByLabel('Email').fill('david@docampo.ch');
  await page.getByRole('button', { name: 'Email Password Reset Link' }).click();
  await page.getByText('We have emailed your password').isVisible();
});