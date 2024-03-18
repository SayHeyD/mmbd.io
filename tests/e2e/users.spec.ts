import {expect, test} from '@playwright/test';
import common from './common';


test('Admin user can reset password', async ({ page, context }) => {
  await page.goto(`${common.appUrl}/login`);
  await page.getByRole('link', { name: 'Forgot your password?' }).click();
  await page.waitForURL('**/forgot-password');

  // Single email for each browser is needed to avoid email reset timeouts,
  // since tests are executed in parallel
  switch (context.browser().browserType().name()) {
    case 'chromium':
      await page.getByLabel('Email').fill(common.testEmails.chromium);
      break
    case 'firefox':
      await page.getByLabel('Email').fill(common.testEmails.firefox);
      break
    case 'webkit':
      await page.getByLabel('Email').fill(common.testEmails.webkit);
      break
    case 'Mobile Chrome':
      await page.getByLabel('Email').fill(common.testEmails.mobileChrome);
      break
    case 'Mobile Safari':
      await page.getByLabel('Email').fill(common.testEmails.mobileSafari);
      break
  }

  await page.getByRole('button', { name: 'Email Password Reset Link' }).click();
  await page.waitForURL('**/forgot-password', {
    waitUntil: 'domcontentloaded',
  });
  await expect(page.getByTestId('status').first()).toBeVisible();
});