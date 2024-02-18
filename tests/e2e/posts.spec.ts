import {firefox, test} from '@playwright/test';
import common from './common';

test('An unauthenticated user can create a new post', async ({ page, context }) => {

  const browser = await firefox.launch({
    args: [
      '"dom.events.testing.asyncClipboard": true'
    ]
  })

  // Don't run code in firefox
  if (context.browser().browserType().name() != 'firefox') {
    // Grant clipboard permissions to browser context
    await context.grantPermissions(['clipboard-read']);
  }

  await page.goto(`${common.appUrl}/`);
  await page.getByPlaceholder('https://tiktok.com/').click();
  await page.getByPlaceholder('https://tiktok.com/').fill('https://youtube.com/shorts/D4u-BW_YgPA?si=0W4GFPHIxeTNRzAN');
  await page.getByRole('button', { name: 'Get your link!' }).isVisible();
  await page.getByRole('button', { name: 'Get your link!' }).click();
  await page.waitForURL('**/success', {
    waitUntil: 'domcontentloaded',
  });
  await page.getByRole('heading', { name: 'Your post is ready! 🎉' }).isVisible();
  await page.getByTestId('copyUrl').click();
  await page.getByText('URL Copied!').isVisible();

  const handle = await page.evaluateHandle(() => navigator.clipboard.readText());
  const clipboardContent = await handle.jsonValue();

  await page.goto(clipboardContent);
  await page.getByRole('link', { name: 'Create a new post' }).click();
  await page.waitForURL('**/', {
    waitUntil: 'domcontentloaded',
  });
});
