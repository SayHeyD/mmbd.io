import {test} from '@playwright/test';
import common from './common';

test('An unauthenticated user can create a new post', async ({ page, context }) => {

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

  if (context.browser().browserType().name() != 'firefox') {
    const handle = await page.evaluateHandle(() => navigator.clipboard.readText());
    const clipboardContent = await handle.jsonValue();
    await page.goto(clipboardContent);
  } else {
    const postUrl = await page.getByTestId('copyUrlInput').inputValue();
    await page.goto(postUrl);
  }

  await page.getByRole('link', { name: 'Create a new post' }).click();
  await page.waitForURL('**/', {
    waitUntil: 'domcontentloaded',
  });
});
